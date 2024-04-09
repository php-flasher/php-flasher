<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Http;

use Flasher\Symfony\Http\Request;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * This class is responsible for testing Flasher\Symfony\Http\Request.
 */
final class RequestTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&SymfonyRequest $symfonyRequestMock;

    protected function setUp(): void
    {
        $this->symfonyRequestMock = \Mockery::mock(SymfonyRequest::class);
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

    /**
     * Test isHtmlRequestFormat method.
     */
    public function testIsHtmlRequestFormat(): void
    {
        $this->symfonyRequestMock->expects('getRequestFormat')->once()->andReturns('html');

        $request = new Request($this->symfonyRequestMock);

        $this->assertTrue($request->isHtmlRequestFormat());
    }

    /**
     * Test hasSession method.
     */
    public function testHasSession(): void
    {
        $this->symfonyRequestMock->expects('hasSession')->andReturns(true);

        $request = new Request($this->symfonyRequestMock);

        $this->assertTrue($request->hasSession());
    }

    public static function sessionStatusProvider(): \Iterator
    {
        yield 'Session Started' => [true];
        yield 'Session Not Started' => [false];
        yield 'No Session' => [false];
    }

    /**
     * Test getSession method.
     */
    #[DataProvider('sessionStatusProvider')]
    public function testIsSessionStarted(bool $isStarted): void
    {
        $sessionMock = \Mockery::mock(SessionInterface::class);
        $sessionMock->expects()->isStarted()->andReturns($isStarted);

        $this->symfonyRequestMock->expects()->getSession()->andReturns($sessionMock);

        $request = new Request($this->symfonyRequestMock);
        $this->assertSame($isStarted, $request->isSessionStarted());
    }

    /**
     * Test hasType method.
     */
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

    /**
     * Test hasHeader method.
     */
    public function testHasHeader(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects()->has('Authorization')->andReturns('Bearer token');

        $this->symfonyRequestMock->headers = $headersMock;

        $request = new Request($this->symfonyRequestMock);

        $this->assertTrue($request->hasHeader('Authorization'));
    }

    /**
     * Test getHeader method.
     */
    public function testGetHeader(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects('get')->with('Authorization')->andReturns('Bearer token');

        $this->symfonyRequestMock->headers = $headersMock;

        $request = new Request($this->symfonyRequestMock);

        $this->assertSame('Bearer token', $request->getHeader('Authorization'));
    }
}
