<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Http;

use Flasher\Laravel\Http\Request;
use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Session\Store as SessionStore;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;

final class RequestTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&LaravelRequest $laravelRequestMock;

    protected function setUp(): void
    {
        $this->laravelRequestMock = \Mockery::mock(LaravelRequest::class);
    }

    public function testIsXmlHttpRequest(): void
    {
        $this->laravelRequestMock->expects('ajax')->andReturns(true);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->isXmlHttpRequest());
    }

    public function testIsHtmlRequestFormat(): void
    {
        $this->laravelRequestMock->expects('acceptsHtml')->andReturns(true);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->isHtmlRequestFormat());
    }

    public function testHasSession(): void
    {
        $this->laravelRequestMock->expects('hasSession')->andReturns(true);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->hasSession());
    }

    public function testIsSessionStarted(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('isStarted')->andReturns(true);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertTrue($request->isSessionStarted());
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

    public function testGetType(): void
    {
        $expectedValue = 'value';
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('get')->with('type')->andReturns($expectedValue);

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $this->assertSame($expectedValue, $request->getType('type'));
    }

    public function testForgetType(): void
    {
        $sessionMock = \Mockery::mock(SessionStore::class);
        $sessionMock->expects('forget')->with('type');

        $this->laravelRequestMock->expects('session')->andReturns($sessionMock);

        $request = new Request($this->laravelRequestMock);

        $request->forgetType('type');
    }
}
