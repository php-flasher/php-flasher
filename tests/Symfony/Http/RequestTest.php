<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Http;

use Flasher\Symfony\Http\Request;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class RequestTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&SymfonyRequest $symfonyRequestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->symfonyRequestMock = \Mockery::mock(SymfonyRequest::class);
    }

    public function testGetUri(): void
    {
        $expectedUri = '/some/path?query=value';
        $this->symfonyRequestMock->expects('getRequestUri')->once()->andReturns($expectedUri);

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame($expectedUri, $request->getUri());
    }

    public static function xmlHttpRequestProvider(): \Iterator
    {
        yield 'XML HTTP Request' => [true];
        yield 'Not XML HTTP Request' => [false];
    }

    #[DataProvider('xmlHttpRequestProvider')]
    public function testIsXmlHttpRequest(bool $isXmlHttpRequest): void
    {
        $this->symfonyRequestMock->expects('isXmlHttpRequest')->once()->andReturns($isXmlHttpRequest);

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame($isXmlHttpRequest, $request->isXmlHttpRequest());
    }

    public function testIsHtmlRequestFormat(): void
    {
        $this->symfonyRequestMock->expects('getRequestFormat')->once()->andReturns('html');

        $request = new Request($this->symfonyRequestMock);

        $this->assertTrue($request->isHtmlRequestFormat());
    }

    public function testIsHtmlRequestFormatReturnsFalseForJson(): void
    {
        $this->symfonyRequestMock->expects('getRequestFormat')->once()->andReturns('json');

        $request = new Request($this->symfonyRequestMock);

        $this->assertFalse($request->isHtmlRequestFormat());
    }

    public function testIsHtmlRequestFormatReturnsFalseForXml(): void
    {
        $this->symfonyRequestMock->expects('getRequestFormat')->once()->andReturns('xml');

        $request = new Request($this->symfonyRequestMock);

        $this->assertFalse($request->isHtmlRequestFormat());
    }

    public function testHasSession(): void
    {
        $this->symfonyRequestMock->expects('hasSession')->andReturns(true);

        $request = new Request($this->symfonyRequestMock);

        $this->assertTrue($request->hasSession());
    }

    public function testHasSessionReturnsFalse(): void
    {
        $this->symfonyRequestMock->expects('hasSession')->andReturns(false);

        $request = new Request($this->symfonyRequestMock);

        $this->assertFalse($request->hasSession());
    }

    public static function sessionStatusProvider(): \Iterator
    {
        yield 'Session Started' => [true];
        yield 'Session Not Started' => [false];
    }

    #[DataProvider('sessionStatusProvider')]
    public function testIsSessionStarted(bool $isStarted): void
    {
        $sessionMock = \Mockery::mock(SessionInterface::class);
        $sessionMock->expects()->isStarted()->andReturns($isStarted);

        $this->symfonyRequestMock->expects()->getSession()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);
        $this->assertSame($isStarted, $request->isSessionStarted());
    }

    public function testIsSessionStartedReturnsFalseWhenSessionNotFound(): void
    {
        $this->symfonyRequestMock->expects()->getSession()->andThrow(new SessionNotFoundException());

        $request = new Request($this->symfonyRequestMock);

        $this->assertFalse($request->isSessionStarted());
    }

    public function testHasType(): void
    {
        $type = 'info';

        $flashBagMock = \Mockery::mock(FlashBagInterface::class);
        $flashBagMock->expects()->has($type)->andReturns(true);

        $sessionMock = \Mockery::mock(FlashBagAwareSessionInterface::class);
        $sessionMock->expects()->getFlashBag()->andReturns($flashBagMock);
        $sessionMock->expects()->isStarted()->andReturnTrue();

        $this->symfonyRequestMock->expects()->getSession()->twice()->andReturns($sessionMock);
        $this->symfonyRequestMock->expects()->hasSession()->once()->andReturnTrue();

        $request = new Request($this->symfonyRequestMock);
        $this->assertTrue($request->hasType($type));
    }

    public function testHasTypeReturnsFalseWhenNoSession(): void
    {
        $this->symfonyRequestMock->expects()->hasSession()->andReturnFalse();

        $request = new Request($this->symfonyRequestMock);

        $this->assertFalse($request->hasType('info'));
    }

    public function testHasTypeReturnsFalseWhenSessionNotStarted(): void
    {
        $sessionMock = \Mockery::mock(SessionInterface::class);
        $sessionMock->expects()->isStarted()->andReturnFalse();

        $this->symfonyRequestMock->expects()->hasSession()->andReturnTrue();
        $this->symfonyRequestMock->expects()->getSession()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);

        $this->assertFalse($request->hasType('info'));
    }

    public function testHasTypeReturnsFalseWhenSessionNotFlashBagAware(): void
    {
        $sessionMock = \Mockery::mock(SessionInterface::class);
        $sessionMock->expects()->isStarted()->andReturnTrue();

        $this->symfonyRequestMock->expects()->hasSession()->andReturnTrue();
        $this->symfonyRequestMock->expects()->getSession()->twice()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);

        $this->assertFalse($request->hasType('info'));
    }

    public function testGetType(): void
    {
        $expected = ['message'];

        $flashBagMock = \Mockery::mock(FlashBagInterface::class);
        $flashBagMock->expects()->get('info')->andReturns($expected);

        $sessionMock = \Mockery::mock(FlashBagAwareSessionInterface::class);
        $sessionMock->expects()->getFlashBag()->andReturns($flashBagMock);

        $this->symfonyRequestMock->expects()->getSession()->once()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame($expected, $request->getType('info'));
    }

    public function testGetTypeReturnsEmptyArrayWhenSessionNotFlashBagAware(): void
    {
        $sessionMock = \Mockery::mock(SessionInterface::class);

        $this->symfonyRequestMock->expects()->getSession()->once()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame([], $request->getType('info'));
    }

    public function testGetTypeReturnsEmptyArrayWhenSessionNotFound(): void
    {
        $this->symfonyRequestMock->expects()->getSession()->andThrow(new SessionNotFoundException());

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame([], $request->getType('info'));
    }

    public function testGetTypeWithMultipleMessages(): void
    {
        $expected = ['message1', 'message2', 'message3'];

        $flashBagMock = \Mockery::mock(FlashBagInterface::class);
        $flashBagMock->expects()->get('success')->andReturns($expected);

        $sessionMock = \Mockery::mock(FlashBagAwareSessionInterface::class);
        $sessionMock->expects()->getFlashBag()->andReturns($flashBagMock);

        $this->symfonyRequestMock->expects()->getSession()->once()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame($expected, $request->getType('success'));
    }

    public function testForgetType(): void
    {
        $expected = ['message to forget'];

        $flashBagMock = \Mockery::mock(FlashBagInterface::class);
        $flashBagMock->expects()->get('warning')->andReturns($expected);

        $sessionMock = \Mockery::mock(FlashBagAwareSessionInterface::class);
        $sessionMock->expects()->getFlashBag()->andReturns($flashBagMock);

        $this->symfonyRequestMock->expects()->getSession()->once()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);

        // forgetType calls getType internally which clears the flash bag
        $request->forgetType('warning');
        $this->assertTrue(true); // No exception thrown
    }

    public function testForgetTypeWithNonFlashBagSession(): void
    {
        $sessionMock = \Mockery::mock(SessionInterface::class);

        $this->symfonyRequestMock->expects()->getSession()->once()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);

        // Should not throw
        $request->forgetType('error');
        $this->assertTrue(true);
    }

    public function testHasHeader(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects()->has('Authorization')->andReturns(true);

        $this->symfonyRequestMock->headers = $headersMock;

        $request = new Request($this->symfonyRequestMock);

        $this->assertTrue($request->hasHeader('Authorization'));
    }

    public function testHasHeaderReturnsFalse(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects()->has('X-Custom-Header')->andReturns(false);

        $this->symfonyRequestMock->headers = $headersMock;

        $request = new Request($this->symfonyRequestMock);

        $this->assertFalse($request->hasHeader('X-Custom-Header'));
    }

    public function testGetHeader(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects('get')->with('Authorization')->andReturns('Bearer token');

        $this->symfonyRequestMock->headers = $headersMock;

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame('Bearer token', $request->getHeader('Authorization'));
    }

    public function testGetHeaderReturnsNull(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects('get')->with('Non-Existent')->andReturns(null);

        $this->symfonyRequestMock->headers = $headersMock;

        $request = new Request($this->symfonyRequestMock);

        $this->assertNull($request->getHeader('Non-Existent'));
    }

    public function testGetHeaderWithContentType(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects('get')->with('Content-Type')->andReturns('application/json');

        $this->symfonyRequestMock->headers = $headersMock;

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame('application/json', $request->getHeader('Content-Type'));
    }
}
