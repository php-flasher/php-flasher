<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Http;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandlerInterface;
use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseExtension;
use Flasher\Prime\Http\ResponseInterface;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ResponseExtensionTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRenderWithHtmlInjection(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);
        $htmlResponse = '<div>Flasher HTML</div>';

        $contentBefore = 'before content '.HtmlPresenter::BODY_END_PLACE_HOLDER.' after content';

        $cspHandler->expects()->updateResponseHeaders($request, $response)->once()->andReturn([
            'csp_script_nonce' => 'script-nonce',
            'csp_style_nonce' => 'style-nonce',
        ]);

        $flasher->expects()->render('html', [], [
            'envelopes_only' => false,
            'csp_script_nonce' => 'script-nonce',
            'csp_style_nonce' => 'style-nonce',
        ])->once()->andReturn($htmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
            'setContent' => \Mockery::on(function ($content) use ($htmlResponse) {
                $expectedContent = 'before content '.$htmlResponse."\n".' after content';
                $this->assertSame($expectedContent, $content);

                return true;
            }),
        ]);

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $modifiedResponse = $responseExtension->render($request, $response);

        $this->assertInstanceOf(ResponseInterface::class, $modifiedResponse);
    }

    public function testRenderNotRenderableDueToAjaxRequest(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $request->allows([
            'isXmlHttpRequest' => true,
            'isHtmlRequestFormat' => false,
        ]);

        $response->allows('getContent')->never();
        $flasher->allows('render')->never();

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $unmodifiedResponse = $responseExtension->render($request, $response);

        $this->assertSame($response, $unmodifiedResponse);
    }

    public function testRenderWithoutPlaceholder(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $contentBefore = 'content without placeholder';

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
        ]);

        $flasher->allows('render')->never();

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $unmodifiedResponse = $responseExtension->render($request, $response);

        $this->assertSame($response, $unmodifiedResponse);
    }

    #[DataProvider('placeholderProvider')]
    public function testRenderWithDifferentPlaceholders(string $placeholder): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);
        $htmlResponse = '<div>Flasher HTML</div>';

        $contentBefore = "before content {$placeholder} after content";

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($htmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
            'setContent' => \Mockery::any(),
        ]);

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $responseExtension->render($request, $response);

        $htmlInjection = HtmlPresenter::FLASHER_REPLACE_ME === $placeholder ? \sprintf('options.push(%s);', $htmlResponse) : $htmlResponse;
        $expectedContent = str_replace($placeholder, "{$htmlInjection}\n{$placeholder}", $contentBefore);

        $response->shouldHaveReceived('setContent')->with($expectedContent)->once();
    }

    public function testRenderWithCspNonces(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $cspNonceScript = 'nonce-script';
        $cspNonceStyle = 'nonce-style';
        $contentBefore = 'content '.HtmlPresenter::BODY_END_PLACE_HOLDER;

        $cspHandler->expects()->updateResponseHeaders($request, $response)->once()->andReturn([
            'csp_script_nonce' => $cspNonceScript,
            'csp_style_nonce' => $cspNonceStyle,
        ]);

        $flasher->expects()->render('html', [], [
            'envelopes_only' => false,
            'csp_script_nonce' => $cspNonceScript,
            'csp_style_nonce' => $cspNonceStyle,
        ])->once()->andReturn('<div>Flasher HTML with CSP</div>');

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
            'setContent' => \Mockery::any(),
        ]);

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $responseExtension->render($request, $response);
    }

    public static function placeholderProvider(): \Iterator
    {
        yield [HtmlPresenter::FLASHER_REPLACE_ME];
        yield [HtmlPresenter::HEAD_END_PLACE_HOLDER];
        yield [HtmlPresenter::BODY_END_PLACE_HOLDER];
    }

    public function testRenderWithEmptyHtmlResponse(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $contentBefore = 'content '.HtmlPresenter::BODY_END_PLACE_HOLDER;

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->expects()->render('html', [], \Mockery::any())->andReturn('');

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
        ]);

        $response->shouldNotHaveReceived('setContent');

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $result = $responseExtension->render($request, $response);

        $this->assertSame($response, $result);
    }

    public function testRenderWithExcludedPath(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        // Create a concrete request class with getUri method for method_exists to work
        $request = new class implements RequestInterface {
            public function isXmlHttpRequest(): bool
            {
                return false;
            }

            public function isHtmlRequestFormat(): bool
            {
                return true;
            }

            public function getUri(): string
            {
                return '/admin/dashboard';
            }

            public function hasSession(): bool
            {
                return false;
            }

            public function isSessionStarted(): bool
            {
                return false;
            }

            public function hasType(string $type): bool
            {
                return false;
            }

            public function getType(string $type): string|array
            {
                return [];
            }

            public function forgetType(string $type): void
            {
            }

            public function hasHeader(string $name): bool
            {
                return false;
            }

            public function getHeader(string $name): ?string
            {
                return null;
            }
        };

        $responseExtension = new ResponseExtension($flasher, $cspHandler, ['#^/admin#']);
        $result = $responseExtension->render($request, $response);

        $this->assertSame($response, $result);
    }

    public function testRenderWithExcludedPathNotMatching(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);
        $htmlResponse = '<div>Flasher</div>';

        $contentBefore = 'content '.HtmlPresenter::BODY_END_PLACE_HOLDER;

        // Create a concrete request class with getUri method for method_exists to work
        $request = new class implements RequestInterface {
            public function isXmlHttpRequest(): bool
            {
                return false;
            }

            public function isHtmlRequestFormat(): bool
            {
                return true;
            }

            public function getUri(): string
            {
                return '/user/profile';
            }

            public function hasSession(): bool
            {
                return false;
            }

            public function isSessionStarted(): bool
            {
                return false;
            }

            public function hasType(string $type): bool
            {
                return false;
            }

            public function getType(string $type): string|array
            {
                return [];
            }

            public function forgetType(string $type): void
            {
            }

            public function hasHeader(string $name): bool
            {
                return false;
            }

            public function getHeader(string $name): ?string
            {
                return null;
            }
        };

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($htmlResponse);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
            'setContent' => \Mockery::any(),
        ]);

        $responseExtension = new ResponseExtension($flasher, $cspHandler, ['#^/admin#']);
        $result = $responseExtension->render($request, $response);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testRenderNotRenderableDueToRedirection(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => true,
            'isAttachment' => false,
            'isJson' => false,
        ]);

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $result = $responseExtension->render($request, $response);

        $this->assertSame($response, $result);
    }

    public function testRenderNotRenderableDueToJson(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => true,
        ]);

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $result = $responseExtension->render($request, $response);

        $this->assertSame($response, $result);
    }

    public function testRenderNotRenderableDueToAttachment(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => true,
            'isJson' => false,
        ]);

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $result = $responseExtension->render($request, $response);

        $this->assertSame($response, $result);
    }

    public function testRenderWithInvalidRegexPatternInExcludedPaths(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);
        $htmlResponse = '<div>Flasher</div>';

        $contentBefore = 'content '.HtmlPresenter::BODY_END_PLACE_HOLDER;

        // Create a concrete request class with getUri method
        $request = new class implements RequestInterface {
            public function isXmlHttpRequest(): bool
            {
                return false;
            }

            public function isHtmlRequestFormat(): bool
            {
                return true;
            }

            public function getUri(): string
            {
                return '/user/profile';
            }

            public function hasSession(): bool
            {
                return false;
            }

            public function isSessionStarted(): bool
            {
                return false;
            }

            public function hasType(string $type): bool
            {
                return false;
            }

            public function getType(string $type): string|array
            {
                return [];
            }

            public function forgetType(string $type): void
            {
            }

            public function hasHeader(string $name): bool
            {
                return false;
            }

            public function getHeader(string $name): ?string
            {
                return null;
            }
        };

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($htmlResponse);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
            'setContent' => \Mockery::any(),
        ]);

        // Test with invalid regex - should trigger warning but continue
        $invalidPatterns = ['[invalid regex'];

        // Suppress the expected warning
        $previousHandler = set_error_handler(fn () => true, \E_USER_WARNING);

        try {
            $responseExtension = new ResponseExtension($flasher, $cspHandler, $invalidPatterns);
            $result = $responseExtension->render($request, $response);

            // Should still render since invalid regex is skipped
            $this->assertInstanceOf(ResponseInterface::class, $result);
        } finally {
            set_error_handler($previousHandler);
        }
    }

    public function testRenderWithUnicodeContent(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $unicodeHtmlResponse = '<div></div>';
        $contentBefore = '<!DOCTYPE html><html><head></head><body>'.HtmlPresenter::BODY_END_PLACE_HOLDER.'</body></html>';

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($unicodeHtmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
            'setContent' => \Mockery::on(function ($content) use ($unicodeHtmlResponse) {
                $this->assertStringContainsString($unicodeHtmlResponse, $content);

                return true;
            }),
        ]);

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $result = $responseExtension->render($request, $response);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testRenderWithSpecialHtmlCharacters(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $specialHtmlResponse = '<div class="flasher" data-message="Test &amp; &lt;script&gt;">Notification</div>';
        $contentBefore = '<html><body>Content with &amp; special <characters>'.HtmlPresenter::BODY_END_PLACE_HOLDER.'</body></html>';

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($specialHtmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
        ]);

        $response->expects('setContent')->once()->with(\Mockery::on(function ($content) use ($specialHtmlResponse) {
            $this->assertStringContainsString($specialHtmlResponse, $content);
            $this->assertStringContainsString('&amp; special', $content);

            return true;
        }));

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $responseExtension->render($request, $response);
    }

    public function testRenderWithVeryLargeResponseBody(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $htmlResponse = '<div>Flasher notification</div>';
        // Create a large content body (simulate a large HTML page)
        $largeContent = str_repeat('<p>Lorem ipsum dolor sit amet</p>', 10000);
        $contentBefore = '<html><body>'.$largeContent.HtmlPresenter::BODY_END_PLACE_HOLDER.'</body></html>';

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($htmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
        ]);

        $response->expects('setContent')->once()->with(\Mockery::on(function ($content) use ($htmlResponse, $largeContent, $contentBefore) {
            $this->assertStringContainsString($htmlResponse, $content);
            $this->assertStringContainsString($largeContent, $content);
            // Verify content length increased by the HTML response
            $this->assertGreaterThan(\strlen($contentBefore), \strlen($content));

            return true;
        }));

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $responseExtension->render($request, $response);
    }

    public function testRenderWithMultiplePlaceholdersUsesLast(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $htmlResponse = '<div>Flasher notification</div>';
        // Content with multiple placeholders - should use the last one found (BODY_END_PLACE_HOLDER)
        $contentBefore = '<html>'.HtmlPresenter::HEAD_END_PLACE_HOLDER.'<body>content'.HtmlPresenter::BODY_END_PLACE_HOLDER.'</body></html>';

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($htmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
        ]);

        $response->expects('setContent')->once()->with(\Mockery::on(function ($content) use ($htmlResponse) {
            // The injection should happen at the last placeholder found (strripos)
            // Based on the code, it iterates through placeholders and uses the last position found
            $this->assertStringContainsString($htmlResponse, $content);

            return true;
        }));

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $responseExtension->render($request, $response);
    }

    public function testRenderPreservesContentEncoding(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        $htmlResponse = '<div>Notification</div>';
        // Content with various encodings and character sets
        $contentBefore = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"></head><body>Content with special chars: &copy; &trade; &nbsp;'.HtmlPresenter::BODY_END_PLACE_HOLDER.'</body></html>';

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($htmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
        ]);

        $response->expects('setContent')->once()->with(\Mockery::on(function ($content) {
            // Verify HTML entities are preserved
            $this->assertStringContainsString('&copy;', $content);
            $this->assertStringContainsString('&trade;', $content);
            $this->assertStringContainsString('&nbsp;', $content);
            $this->assertStringContainsString('charset="UTF-8"', $content);

            return true;
        }));

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $responseExtension->render($request, $response);
    }

    public function testRenderWithEmptyBody(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        // Empty body but with placeholder
        $contentBefore = HtmlPresenter::BODY_END_PLACE_HOLDER;
        $htmlResponse = '<div>Flasher</div>';

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        $flasher->allows()->render('html', [], \Mockery::any())->andReturn($htmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
        ]);

        $response->expects('setContent')->once()->with(\Mockery::on(function ($content) use ($htmlResponse) {
            $this->assertStringContainsString($htmlResponse, $content);

            return true;
        }));

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $responseExtension->render($request, $response);
    }

    public function testRenderWithFlasherReplaceMePlaceholder(): void
    {
        $flasher = \Mockery::mock(FlasherInterface::class);
        $cspHandler = \Mockery::mock(ContentSecurityPolicyHandlerInterface::class);
        $request = \Mockery::mock(RequestInterface::class);
        $response = \Mockery::mock(ResponseInterface::class);

        // Using FLASHER_REPLACE_ME placeholder triggers special handling
        $contentBefore = 'content '.HtmlPresenter::FLASHER_REPLACE_ME.' more content';
        $htmlResponse = '{"envelopes":[]}';

        $cspHandler->allows()->updateResponseHeaders($request, $response)->andReturn([]);
        // When FLASHER_REPLACE_ME is used, envelopes_only should be true
        $flasher->expects()->render('html', [], \Mockery::on(function ($context) {
            return true === $context['envelopes_only'];
        }))->once()->andReturn($htmlResponse);

        $request->allows([
            'isXmlHttpRequest' => false,
            'isHtmlRequestFormat' => true,
        ]);

        $response->allows([
            'isSuccessful' => true,
            'isHtml' => true,
            'isRedirection' => false,
            'isAttachment' => false,
            'isJson' => false,
            'getContent' => $contentBefore,
        ]);

        $response->expects('setContent')->once()->with(\Mockery::on(function ($content) {
            // Should wrap with options.push()
            $this->assertStringContainsString('options.push(', $content);

            return true;
        }));

        $responseExtension = new ResponseExtension($flasher, $cspHandler);
        $responseExtension->render($request, $response);
    }
}
