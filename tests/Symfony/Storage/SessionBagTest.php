<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Symfony\Storage\FallbackSessionInterface;
use Flasher\Symfony\Storage\SessionBag;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionBagTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&RequestStack $requestStackMock;
    private MockInterface&FallbackSessionInterface $fallbackSessionMock;
    private SessionBag $sessionBag;

    protected function setUp(): void
    {
        $this->requestStackMock = \Mockery::mock(RequestStack::class);
        $this->fallbackSessionMock = \Mockery::mock(FallbackSessionInterface::class);
        $this->sessionBag = new SessionBag($this->requestStackMock, $this->fallbackSessionMock);
    }

    public function testGet(): void
    {
        $sessionMock = \Mockery::mock(SessionInterface::class);
        $sessionMock->expects('get')->andReturns([new Envelope(new Notification(), new IdStamp('1111'))]);

        $parameterBagMock = \Mockery::mock(ParameterBag::class);
        $parameterBagMock->expects()->get('_stateless', false)->andReturns(false);

        $requestMock = \Mockery::mock(SymfonyRequest::class);
        $requestMock->attributes = $parameterBagMock;

        $this->requestStackMock->expects()->getCurrentRequest()->andReturns($requestMock);
        $this->requestStackMock->expects()->getSession()->andReturns($sessionMock);

        $result = $this->sessionBag->get();

        $this->assertIsArray($result);
        $this->assertInstanceOf(Envelope::class, $result[0]);
    }

    public function testSet(): void
    {
        $sessionMock = \Mockery::mock(SessionInterface::class);
        $sessionMock->expects('set');

        $parameterBagMock = \Mockery::mock(ParameterBag::class);
        $parameterBagMock->expects()->get('_stateless', false)->andReturns(false);

        $requestMock = \Mockery::mock(SymfonyRequest::class);
        $requestMock->attributes = $parameterBagMock;

        $this->requestStackMock->expects()->getCurrentRequest()->andReturns($requestMock);
        $this->requestStackMock->expects()->getSession()->andReturns($sessionMock);

        $this->sessionBag->set([]);
    }

    public function testFallbackSession(): void
    {
        $this->fallbackSessionMock->allows('get')
            ->andReturns([new Envelope(new Notification(), new IdStamp('1111'))]);

        $this->requestStackMock->expects()->getCurrentRequest()->andReturns(null);

        $result = $this->sessionBag->get();

        $this->assertIsArray($result);
        $this->assertInstanceOf(Envelope::class, $result[0]);
    }
}
