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
}
