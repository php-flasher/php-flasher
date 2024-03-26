<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Http;

use Flasher\Symfony\Http\Response;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

final class ResponseTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&ResponseHeaderBag $responseHeaderBagMock;
    private MockInterface&SymfonyResponse $responseMock;

    protected function setUp(): void
    {
        $this->responseHeaderBagMock = \Mockery::mock(ResponseHeaderBag::class);

        $this->responseMock = \Mockery::mock(SymfonyResponse::class);
        $this->responseMock->headers = $this->responseHeaderBagMock;
    }

    public function testIsRedirection(): void
    {
        $this->responseMock->expects()->isRedirection()->andReturns(true);

        $response = new Response($this->responseMock);

        $this->assertTrue($response->isRedirection());
    }

    public function testIsJson(): void
    {
        $jsonResponseMock = \Mockery::mock(JsonResponse::class);

        $response = new Response($jsonResponseMock);

        $this->assertTrue($response->isJson());
    }

    public function testIsHtml(): void
    {
        $this->responseHeaderBagMock->expects()->get('Content-Type')->andReturns('text/html; charset=UTF-8');

        $response = new Response($this->responseMock);

        $this->assertTrue($response->isHtml());
    }

    public function testIsAttachment(): void
    {
        $this->responseHeaderBagMock->expects()->get('Content-Disposition', '')->andReturns('attachment; filename="filename.jpg"');

        $response = new Response($this->responseMock);

        $this->assertTrue($response->isAttachment());
    }

    public function testIsSuccessful(): void
    {
        $this->responseMock->expects()->isSuccessful()->andReturns(true);

        $response = new Response($this->responseMock);

        $this->assertTrue($response->isSuccessful());
    }

    public function testGetContent(): void
    {
        $expectedContent = 'response content';
        $this->responseMock->expects()->getContent()->andReturns($expectedContent);

        $response = new Response($this->responseMock);

        $this->assertSame($expectedContent, $response->getContent());
    }

    public function testSetContent(): void
    {
        $newContent = 'new content';
        $this->responseMock->expects()->setContent($newContent);

        $response = new Response($this->responseMock);
        $response->setContent($newContent);
    }

    public function testHasHeader(): void
    {
        $headerKey = 'X-Custom-Header';
        $this->responseHeaderBagMock->expects()->has($headerKey)->andReturns(true);

        $response = new Response($this->responseMock);

        $this->assertTrue($response->hasHeader($headerKey));
    }

    public function testGetHeader(): void
    {
        $headerKey = 'X-Custom-Header';
        $headerValue = 'Value';
        $this->responseHeaderBagMock->expects()->get($headerKey)->andReturns($headerValue);

        $response = new Response($this->responseMock);

        $this->assertSame($headerValue, $response->getHeader($headerKey));
    }

    public function testSetHeader(): void
    {
        $headerKey = 'X-Custom-Header';
        $headerValue = 'Value';
        $this->responseHeaderBagMock->expects()->set($headerKey, $headerValue);

        $response = new Response($this->responseMock);
        $response->setHeader($headerKey, $headerValue);
    }

    public function testRemoveHeader(): void
    {
        $headerKey = 'X-Custom-Header';
        $this->responseHeaderBagMock->expects()->remove($headerKey);

        $response = new Response($this->responseMock);
        $response->removeHeader($headerKey);
    }
}
