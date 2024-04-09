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

        $htmlInjection = HtmlPresenter::FLASHER_REPLACE_ME === $placeholder ? sprintf('options.push(%s);', $htmlResponse) : $htmlResponse;
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
}
