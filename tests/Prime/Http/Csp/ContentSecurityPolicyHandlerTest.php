<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Http\Csp;

use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandler;
use Flasher\Prime\Http\Csp\NonceGeneratorInterface;
use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ContentSecurityPolicyHandlerTest extends TestCase
{
    private ContentSecurityPolicyHandler $cspHandler;

    /** @var MockObject&NonceGeneratorInterface */
    private MockObject $nonceGeneratorMock;

    /** @var MockObject&RequestInterface */
    private MockObject $requestMock;

    /** @var MockObject&ResponseInterface */
    private MockObject $responseMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nonceGeneratorMock = $this->createMock(NonceGeneratorInterface::class);
        $this->requestMock = $this->createMock(RequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);

        $this->cspHandler = new ContentSecurityPolicyHandler($this->nonceGeneratorMock);
    }

    public function testGetNoncesFromRequestHeaders(): void
    {
        $this->requestMock->method('hasHeader')->willReturnCallback(function ($headerName) {
            return \in_array($headerName, ['X-PHPFlasher-Script-Nonce', 'X-PHPFlasher-Style-Nonce']);
        });
        $this->requestMock->method('getHeader')->willReturnCallback(function ($headerName) {
            return 'X-PHPFlasher-Script-Nonce' === $headerName ? 'test-script-nonce' : 'test-style-nonce';
        });

        $nonces = $this->cspHandler->getNonces($this->requestMock);

        $this->assertSame([
            'csp_script_nonce' => 'test-script-nonce',
            'csp_style_nonce' => 'test-style-nonce',
        ], $nonces);
    }

    public function testGetNoncesFromResponseHeaders(): void
    {
        $this->requestMock->method('hasHeader')->willReturnCallback(function ($headerName) {
            return \in_array($headerName, ['X-PHPFlasher-Script-Nonce', 'X-PHPFlasher-Style-Nonce']);
        });
        $this->requestMock->method('getHeader')->willReturnCallback(function ($headerName) {
            return 'X-PHPFlasher-Script-Nonce' === $headerName ? 'test-script-nonce' : 'test-style-nonce';
        });

        $nonces = $this->cspHandler->getNonces($this->requestMock, $this->responseMock);

        $this->assertSame([
            'csp_script_nonce' => 'test-script-nonce',
            'csp_style_nonce' => 'test-style-nonce',
        ], $nonces);
    }

    public function testGetGeneratedNonces(): void
    {
        $this->nonceGeneratorMock->method('generate')
            ->willReturn('generated-nonce');

        $this->responseMock->expects($this->exactly(2))
            ->method('setHeader')
            ->willReturnCallback(function ($headerName, $value) {
                static $calls = 0;
                switch (++$calls) {
                    case 1:
                        $this->assertSame('X-PHPFlasher-Script-Nonce', $headerName);
                        $this->assertSame('generated-nonce', $value);
                        break;
                    case 2:
                        $this->assertSame('X-PHPFlasher-Style-Nonce', $headerName);
                        $this->assertSame('generated-nonce', $value);
                        break;
                    default:
                        $this->fail('setHeader called more than twice.');
                }
            });

        $nonces = $this->cspHandler->getNonces($this->requestMock, $this->responseMock);

        $this->assertSame([
            'csp_script_nonce' => 'generated-nonce',
            'csp_style_nonce' => 'generated-nonce',
        ], $nonces);
    }

    public function testDisableCsp(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        // Simulate the internal tracking of CSP headers.
        $cspHeaders = [
            'Content-Security-Policy' => true,
            'X-Content-Security-Policy' => true,
        ];

        // Simulate response behavior based on CSP header tracking.
        $response->method('hasHeader')->willReturnCallback(function ($headerName) use (&$cspHeaders) {
            return !empty($cspHeaders[$headerName]);
        });

        // Mock the removal of headers to update our simulated tracking.
        $response->method('removeHeader')->willReturnCallback(function ($headerName) use (&$cspHeaders) {
            unset($cspHeaders[$headerName]);
        });

        // Assuming CSP is initially enabled and headers are present.
        // This call should set CSP headers.
        $this->cspHandler->updateResponseHeaders($request, $response);

        // Check if CSP headers are initially present.
        $this->assertTrue($response->hasHeader('Content-Security-Policy'));
        $this->assertTrue($response->hasHeader('X-Content-Security-Policy'));

        // Disabling CSP.
        $this->cspHandler->disableCsp();

        // Now CSP headers should be removed.
        // This call should remove CSP headers.
        $this->cspHandler->updateResponseHeaders($request, $response);

        // Check if CSP headers are removed.
        $this->assertFalse($response->hasHeader('Content-Security-Policy'));
        $this->assertFalse($response->hasHeader('X-Content-Security-Policy'));
    }

    public function testUpdateResponseHeadersWhenCspIsDisabled(): void
    {
        $removedHeaders = [];
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($headerName) use (&$removedHeaders) {
            $removedHeaders[] = $headerName;
        });

        $this->cspHandler->disableCsp();
        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $expectedRemovedHeaders = [
            'Content-Security-Policy',
            'X-Content-Security-Policy',
            'Content-Security-Policy-Report-Only',
        ];
        $this->assertSame([], $nonces);
        foreach ($expectedRemovedHeaders as $header) {
            $this->assertContains($header, $removedHeaders, "$header was not removed.");
        }
    }

    public function testUpdateResponseHeadersWhenCspIsEnabled(): void
    {
        $setHeaders = [];
        $this->responseMock->method('setHeader')->willReturnCallback(function ($headerName, $value) use (&$setHeaders) {
            $setHeaders[$headerName] = $value;
        });

        $this->nonceGeneratorMock->method('generate')->willReturnOnConsecutiveCalls('nonce1', 'nonce2', 'nonce3', 'nonce4');

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        // Verify that nonces were generated and set as expected
        $this->assertCount(2, $setHeaders, 'Expected two headers to be set.');
        $this->assertSame('nonce1', $setHeaders['X-PHPFlasher-Script-Nonce']);
        $this->assertSame('nonce2', $setHeaders['X-PHPFlasher-Style-Nonce']);

        $this->assertSame([
            'csp_script_nonce' => 'nonce1',
            'csp_style_nonce' => 'nonce2',
        ], $nonces);
    }

    public function testGetNoncesFromHeaders(): void
    {
        $nonces = ['csp_script_nonce' => 'random1', 'csp_style_nonce' => 'random2'];

        $this->requestMock->method('hasHeader')->willReturn(true);

        $this->requestMock->expects($this->exactly(2))->method('getHeader')
            ->willReturnCallback(function ($header) use ($nonces) {
                return 'X-PHPFlasher-Script-Nonce' === $header ? $nonces['csp_script_nonce'] : $nonces['csp_style_nonce'];
            });

        $result = $this->cspHandler->getNonces($this->requestMock);
        $this->assertSame($nonces, $result);
    }

    public function testGetNoncesFromResponseHeadersWhenNoHeadersInRequest(): void
    {
        $nonces = ['csp_script_nonce' => 'random3', 'csp_style_nonce' => 'random4'];

        $this->requestMock->method('hasHeader')->willReturn(false);
        $this->responseMock->method('hasHeader')->willReturn(true);

        $this->responseMock->expects($this->exactly(2))->method('getHeader')
            ->willReturnCallback(function ($header) use ($nonces) {
                return 'X-PHPFlasher-Script-Nonce' === $header ? $nonces['csp_script_nonce'] : $nonces['csp_style_nonce'];
            });

        $result = $this->cspHandler->getNonces($this->requestMock, $this->responseMock);
        $this->assertSame($nonces, $result);
    }

    public function testGetNoncesWithRandomGeneratedNoncesWhenHeadersEmpty(): void
    {
        $nonces = ['csp_script_nonce' => 'random5', 'csp_style_nonce' => 'random6'];

        $this->nonceGeneratorMock->expects($this->exactly(2))->method('generate')
            ->willReturnCallback(function () use ($nonces) {
                static $i = 0;

                return $i++ ? $nonces['csp_style_nonce'] : $nonces['csp_script_nonce'];
            });

        $this->requestMock->expects($this->exactly(1))->method('hasHeader')->willReturn(false);
        $this->responseMock->expects($this->exactly(1))->method('hasHeader')->willReturn(false);

        $this->responseMock->expects($this->exactly(2))->method('setHeader')
            ->willReturnCallback(function ($headerName, $headerValue) {
                static $i = 0;
                if (0 === $i++) {
                    $this->assertSame('X-PHPFlasher-Script-Nonce', $headerName);
                    $this->assertSame('random5', $headerValue);
                } else {
                    $this->assertSame('X-PHPFlasher-Style-Nonce', $headerName);
                    $this->assertSame('random6', $headerValue);
                }
            });

        $result = $this->cspHandler->getNonces($this->requestMock, $this->responseMock);
        $this->assertSame($nonces, $result);
    }

    public function testUpdateResponseHeadersWithCspPolicies(): void
    {
        $this->nonceGeneratorMock->method('generate')
            ->willReturnOnConsecutiveCalls('nonce1', 'nonce2', 'nonce3', 'nonce4');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // Set an initial CSP header
        $headers['Content-Security-Policy'] = "script-src 'self'; style-src 'self'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertArrayHasKey('csp_script_nonce', $nonces);
        $this->assertArrayHasKey('csp_style_nonce', $nonces);
    }

    public function testUpdateResponseHeadersWithDefaultSrcNone(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('testnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // Set CSP with default-src 'none'
        $headers['Content-Security-Policy'] = "default-src 'none'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);
    }

    public function testUpdateResponseHeadersWithUnsafeInlineAndNonce(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('testnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // CSP with 'unsafe-inline' already present but with nonce (nonce takes precedence)
        $headers['Content-Security-Policy'] = "script-src 'self' 'unsafe-inline' 'nonce-existing'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);
    }

    public function testUpdateResponseHeadersWithReportOnlyHeader(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('reportnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        $headers['Content-Security-Policy-Report-Only'] = "script-src 'self'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);
    }

    public function testUpdateResponseHeadersWithHashDirective(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('hashnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // CSP with sha256 hash
        $headers['Content-Security-Policy'] = "script-src 'self' 'sha256-abc123'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);
    }

    public function testUpdateResponseHeadersWithXContentSecurityPolicy(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('xcsplnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // Legacy X-Content-Security-Policy header
        $headers['X-Content-Security-Policy'] = "script-src 'self'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);
    }

    public function testUpdateResponseHeadersWithStyleSrcElem(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('stylnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        $headers['Content-Security-Policy'] = "style-src-elem 'self'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);
    }

    public function testGetNoncesWithoutResponse(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('noresponsenonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $nonces = $this->cspHandler->getNonces($this->requestMock);

        $this->assertSame([
            'csp_script_nonce' => 'noresponsenonce',
            'csp_style_nonce' => 'noresponsenonce',
        ], $nonces);
    }

    public function testResetRestoresCspEnabled(): void
    {
        // First, disable CSP
        $this->cspHandler->disableCsp();

        // Verify it's disabled by checking updateResponseHeaders returns empty
        $removedHeaders = [];
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($headerName) use (&$removedHeaders) {
            $removedHeaders[] = $headerName;
        });

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);
        $this->assertSame([], $nonces, 'CSP should be disabled');

        // Reset the handler
        $this->cspHandler->reset();

        // Now CSP should be enabled again
        $this->nonceGeneratorMock->method('generate')->willReturn('resetnonce');

        $setHeaders = [];
        $this->responseMock->method('setHeader')->willReturnCallback(function ($headerName, $value) use (&$setHeaders) {
            $setHeaders[$headerName] = $value;
        });

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces, 'CSP should be enabled after reset');
        $this->assertArrayHasKey('csp_script_nonce', $nonces);
        $this->assertArrayHasKey('csp_style_nonce', $nonces);
    }

    public function testParseDirectivesWithTrailingSemicolons(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('testnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // CSP with trailing semicolons and empty directives
        $headers['Content-Security-Policy'] = "script-src 'self'; ; style-src 'self'; ";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        // Should parse correctly without creating empty key entries
        $this->assertNotEmpty($nonces);

        // Verify the resulting CSP header doesn't have empty directives
        $resultCsp = $headers['Content-Security-Policy'];
        $this->assertStringNotContainsString('; ;', $resultCsp);
    }

    public function testHandlesCsp3Directives(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('csp3nonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // CSP Level 3 directives
        $headers['Content-Security-Policy'] = "script-src 'self'; worker-src 'self'; navigate-to 'self'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);
        $this->assertArrayHasKey('csp_script_nonce', $nonces);

        // The handler should add nonces to script-src but leave worker-src and navigate-to alone
        $resultCsp = $headers['Content-Security-Policy'];
        $this->assertStringContainsString("'nonce-csp3nonce'", $resultCsp);
    }

    public function testHandlesMultipleSourcesInDirective(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('multisourcenonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // CSP with multiple sources in a single directive
        $headers['Content-Security-Policy'] = "script-src 'self' https://cdn.example.com https://api.example.com data: blob:";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);

        $resultCsp = $headers['Content-Security-Policy'];
        // Should preserve existing sources and add nonce
        $this->assertStringContainsString("'self'", $resultCsp);
        $this->assertStringContainsString('https://cdn.example.com', $resultCsp);
        $this->assertStringContainsString('https://api.example.com', $resultCsp);
        $this->assertStringContainsString('data:', $resultCsp);
        $this->assertStringContainsString('blob:', $resultCsp);
        $this->assertStringContainsString("'nonce-multisourcenonce'", $resultCsp);
    }

    public function testHandlesVeryLongCspHeader(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('longnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // Generate a very long CSP header with many directives
        $domains = [];
        for ($i = 0; $i < 50; ++$i) {
            $domains[] = "https://cdn{$i}.example.com";
        }
        $longCsp = "script-src 'self' ".implode(' ', $domains)."; style-src 'self' ".implode(' ', $domains);

        $headers['Content-Security-Policy'] = $longCsp;

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);

        $resultCsp = $headers['Content-Security-Policy'];
        // Should handle the long header without issues
        $this->assertStringContainsString("'nonce-longnonce'", $resultCsp);
        // Verify multiple domains are preserved
        $this->assertStringContainsString('https://cdn0.example.com', $resultCsp);
        $this->assertStringContainsString('https://cdn49.example.com', $resultCsp);
    }

    public function testResetClearsAllState(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('statetestnonce');

        // First, disable CSP and verify it's disabled
        $this->cspHandler->disableCsp();

        $removedHeaders = [];
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($headerName) use (&$removedHeaders) {
            $removedHeaders[] = $headerName;
        });

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);
        $this->assertSame([], $nonces, 'CSP should be disabled');

        // Reset should clear all state including the disabled flag
        $this->cspHandler->reset();

        // Create fresh mocks for the second call
        $request2 = $this->createMock(RequestInterface::class);
        $response2 = $this->createMock(ResponseInterface::class);

        $request2->method('hasHeader')->willReturn(false);

        $setHeaders = [];
        $response2->method('hasHeader')->willReturn(false);
        $response2->method('setHeader')->willReturnCallback(function ($headerName, $value) use (&$setHeaders) {
            $setHeaders[$headerName] = $value;
        });

        // After reset, CSP should be enabled again and generate nonces
        $nonces = $this->cspHandler->updateResponseHeaders($request2, $response2);

        $this->assertNotEmpty($nonces, 'CSP should be enabled after reset');
        $this->assertArrayHasKey('csp_script_nonce', $nonces);
        $this->assertArrayHasKey('csp_style_nonce', $nonces);
        $this->assertSame('statetestnonce', $nonces['csp_script_nonce']);
        $this->assertSame('statetestnonce', $nonces['csp_style_nonce']);
    }

    public function testHandlesScriptSrcElemAndStyleSrcElemDirectives(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('elemnonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // CSP with script-src-elem and style-src-elem (CSP Level 3)
        $headers['Content-Security-Policy'] = "script-src-elem 'self'; style-src-elem 'self'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);

        $resultCsp = $headers['Content-Security-Policy'];
        // Both directives should have nonces added
        $this->assertStringContainsString("'nonce-elemnonce'", $resultCsp);
    }

    public function testHandlesMultipleCspHeaders(): void
    {
        $this->nonceGeneratorMock->method('generate')->willReturn('multinonce');

        $this->requestMock->method('hasHeader')->willReturn(false);

        $headers = [];
        $this->responseMock->method('hasHeader')->willReturnCallback(function ($name) use (&$headers) {
            return isset($headers[$name]);
        });
        $this->responseMock->method('getHeader')->willReturnCallback(function ($name) use (&$headers) {
            return $headers[$name] ?? null;
        });
        $this->responseMock->method('setHeader')->willReturnCallback(function ($name, $value) use (&$headers) {
            $headers[$name] = $value;
        });
        $this->responseMock->method('removeHeader')->willReturnCallback(function ($name) use (&$headers) {
            unset($headers[$name]);
        });

        // Multiple CSP headers (standard, report-only, and legacy X- prefix)
        $headers['Content-Security-Policy'] = "script-src 'self'";
        $headers['Content-Security-Policy-Report-Only'] = "script-src 'self'";
        $headers['X-Content-Security-Policy'] = "script-src 'self'";

        $nonces = $this->cspHandler->updateResponseHeaders($this->requestMock, $this->responseMock);

        $this->assertNotEmpty($nonces);

        // All three headers should be updated with nonces
        $this->assertStringContainsString("'nonce-multinonce'", $headers['Content-Security-Policy']);
        $this->assertStringContainsString("'nonce-multinonce'", $headers['Content-Security-Policy-Report-Only']);
        $this->assertStringContainsString("'nonce-multinonce'", $headers['X-Content-Security-Policy']);
    }

    public function testNoncesPersistAcrossMultipleCalls(): void
    {
        $callCount = 0;
        $this->nonceGeneratorMock->method('generate')->willReturnCallback(function () use (&$callCount) {
            return 'nonce'.++$callCount;
        });

        // First call - nonces from request headers
        $this->requestMock->method('hasHeader')->willReturnCallback(function ($headerName) {
            return \in_array($headerName, ['X-PHPFlasher-Script-Nonce', 'X-PHPFlasher-Style-Nonce']);
        });
        $this->requestMock->method('getHeader')->willReturnCallback(function ($headerName) {
            return 'X-PHPFlasher-Script-Nonce' === $headerName ? 'existing-script-nonce' : 'existing-style-nonce';
        });

        $nonces = $this->cspHandler->getNonces($this->requestMock);

        $this->assertSame([
            'csp_script_nonce' => 'existing-script-nonce',
            'csp_style_nonce' => 'existing-style-nonce',
        ], $nonces);

        // The nonces from headers should be used, not generated ones
        $this->assertSame(0, $callCount, 'No nonces should be generated when headers exist');
    }
}
