<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Http;

use Flasher\Laravel\Http\Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Session\Store as SessionStore;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;

final class RequestTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&LaravelRequest $laravelRequestMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->laravelRequestMock = \Mockery::mock(LaravelRequest::class);
    }

    public function testGetUri(): void
    {
        $expectedUri = 'https://example.com/some/path?query=value';
        $this->laravelRequestMock->expects('getUri')->andReturns($expectedUri);

        $request = new Request($this->laravelRequestMock);

        $this->assertSame($expectedUri, $request->getUri());
    }

    public function testIsXmlHttpRequest(): void
    {
        $this->laravelRequestMock->expects('ajax')->andReturns(true);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->isXmlHttpRequest());
    }

    public function testIsXmlHttpRequestReturnsFalse(): void
    {
        $this->laravelRequestMock->expects('ajax')->andReturns(false);

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->isXmlHttpRequest());
    }

    public function testIsHtmlRequestFormat(): void
    {
        $this->laravelRequestMock->expects('acceptsHtml')->andReturns(true);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->isHtmlRequestFormat());
    }

    public function testIsHtmlRequestFormatReturnsFalse(): void
    {
        $this->laravelRequestMock->expects('acceptsHtml')->andReturns(false);

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->isHtmlRequestFormat());
    }

    public function testHasSession(): void
    {
        $this->laravelRequestMock->expects('hasSession')->andReturns(true);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->hasSession());
    }

    public function testHasSessionReturnsFalse(): void
    {
        $this->laravelRequestMock->expects('hasSession')->andReturns(false);

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->hasSession());
    }

    public function testIsSessionStarted(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('isStarted')->andReturns(true);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->isSessionStarted());
    }

    public function testIsSessionStartedReturnsFalseWhenNotStarted(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('isStarted')->andReturns(false);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->isSessionStarted());
    }

    public function testIsSessionStartedReturnsFalseWhenSessionThrowsException(): void
    {
        $this->laravelRequestMock->expects('session')->andThrow(new \RuntimeException('Session not available'));

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->isSessionStarted());
    }

    public function testHasType(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('has')->with('type')->andReturns(true);
        $sessionMock->expects('isStarted')->andReturns(true);

        $this->laravelRequestMock->expects('session')->twice()->andReturns($sessionMock);
        $this->laravelRequestMock->expects('hasSession')->andReturn(true);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->hasType('type'));
    }

    public function testHasTypeReturnsFalseWhenNoSession(): void
    {
        $this->laravelRequestMock->expects('hasSession')->andReturn(false);

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->hasType('type'));
    }

    public function testHasTypeReturnsFalseWhenSessionNotStarted(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('isStarted')->andReturns(false);

        $this->laravelRequestMock->expects('hasSession')->andReturn(true);
        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->hasType('type'));
    }

    public function testHasTypeReturnsFalseWhenSessionHasReturnsNull(): void
    {
        $sessionMock = \Mockery::mock(Session::class);
        $sessionMock->expects('isStarted')->andReturns(true);
        $sessionMock->expects('has')->with('type')->andReturns(false);

        $this->laravelRequestMock->expects('hasSession')->andReturn(true);
        $this->laravelRequestMock->expects('session')->twice()->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->hasType('type'));
    }

    public function testGetTypeReturnsString(): void
    {
        $expectedValue = 'value';
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('get')->with('type')->andReturns($expectedValue);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertSame($expectedValue, $request->getType('type'));
    }

    public function testGetTypeReturnsArray(): void
    {
        $expectedValue = ['value1', 'value2'];
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('get')->with('type')->andReturns($expectedValue);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertSame($expectedValue, $request->getType('type'));
    }

    public function testGetTypeReturnsEmptyArrayWhenValueIsNull(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('get')->with('type')->andReturns(null);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertSame([], $request->getType('type'));
    }

    public function testGetTypeReturnsEmptyArrayWhenValueIsInteger(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('get')->with('type')->andReturns(123);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertSame([], $request->getType('type'));
    }

    public function testGetTypeReturnsEmptyArrayWhenValueIsFalse(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('get')->with('type')->andReturns(false);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertSame([], $request->getType('type'));
    }

    public function testGetTypeReturnsEmptyArrayWhenSessionThrowsException(): void
    {
        $this->laravelRequestMock->expects('session')->andThrow(new \RuntimeException('Session not available'));

        $request = new Request($this->laravelRequestMock);

        $this->assertSame([], $request->getType('type'));
    }

    public function testForgetType(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('forget')->with('type');

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $request->forgetType('type');
    }

    public function testForgetTypeWhenSessionThrowsException(): void
    {
        $this->laravelRequestMock->expects('session')->andThrow(new \RuntimeException('Session not available'));

        $request = new Request($this->laravelRequestMock);

        // Should not throw, just silently fail
        $request->forgetType('type');
        $this->assertTrue(true);
    }

    public function testHasHeader(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects('has')->with('X-Custom-Header')->andReturns(true);

        $this->laravelRequestMock->headers = $headersMock;

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->hasHeader('X-Custom-Header'));
    }

    public function testHasHeaderReturnsFalse(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects('has')->with('X-Custom-Header')->andReturns(false);

        $this->laravelRequestMock->headers = $headersMock;

        $request = new Request($this->laravelRequestMock);

        $this->assertFalse($request->hasHeader('X-Custom-Header'));
    }

    public function testGetHeader(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects('get')->with('Authorization')->andReturns('Bearer token123');

        $this->laravelRequestMock->headers = $headersMock;

        $request = new Request($this->laravelRequestMock);

        $this->assertSame('Bearer token123', $request->getHeader('Authorization'));
    }

    public function testGetHeaderReturnsNull(): void
    {
        $headersMock = \Mockery::mock(HeaderBag::class);
        $headersMock->expects('get')->with('Non-Existent-Header')->andReturns(null);

        $this->laravelRequestMock->headers = $headersMock;

        $request = new Request($this->laravelRequestMock);

        $this->assertNull($request->getHeader('Non-Existent-Header'));
    }
}
