<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\EventListener;

use Flasher\Prime\Http\RequestExtensionInterface;
use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseInterface;
use Flasher\Symfony\EventListener\SessionListener;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class SessionListenerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&RequestExtensionInterface $requestExtensionMock;
    private SessionListener $sessionListener;

    protected function setUp(): void
    {
        $this->requestExtensionMock = \Mockery::mock(RequestExtensionInterface::class);
        $this->sessionListener = new SessionListener($this->requestExtensionMock);
    }

    public function testOnKernelResponse(): void
    {
        $kernelMock = \Mockery::mock(HttpKernelInterface::class);
        $requestMock = \Mockery::mock(SymfonyRequest::class);
        $responseMock = \Mockery::mock(SymfonyResponse::class);

        // Assuming the flash method does not return a value and is just called to perform an action.
        $this->requestExtensionMock->expects()
            ->flash(\Mockery::type(RequestInterface::class), \Mockery::type(ResponseInterface::class))
            ->once();

        $event = new ResponseEvent($kernelMock, $requestMock, HttpKernelInterface::MAIN_REQUEST, $responseMock);
        $this->sessionListener->onKernelResponse($event);
    }

    public function testGetSubscribedEvents(): void
    {
        $expectedEvents = [ResponseEvent::class => ['onKernelResponse', 0]];
        $subscribedEvents = SessionListener::getSubscribedEvents();

        // Verify that the SessionListener is subscribed to the correct event with the right priority.
        $this->assertSame($expectedEvents, $subscribedEvents);
    }
}
