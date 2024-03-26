<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\EventListener;

use Flasher\Prime\Http\RequestInterface;
use Flasher\Prime\Http\ResponseExtensionInterface;
use Flasher\Prime\Http\ResponseInterface;
use Flasher\Symfony\EventListener\FlasherListener;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class FlasherListenerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&ResponseExtensionInterface $responseExtensionMock;
    private FlasherListener $flasherListener;

    protected function setUp(): void
    {
        $this->responseExtensionMock = \Mockery::mock(ResponseExtensionInterface::class);
        $this->flasherListener = new FlasherListener($this->responseExtensionMock);
    }

    public function testOnKernelResponse(): void
    {
        $kernelMock = \Mockery::mock(HttpKernelInterface::class);
        $requestMock = \Mockery::mock(SymfonyRequest::class);
        $responseMock = \Mockery::mock(SymfonyResponse::class);

        $this->responseExtensionMock->expects()
            ->render(\Mockery::type(RequestInterface::class), \Mockery::type(ResponseInterface::class))
            ->once();

        $event = new ResponseEvent($kernelMock, $requestMock, HttpKernelInterface::MAIN_REQUEST, $responseMock);
        $this->flasherListener->onKernelResponse($event);
    }

    public function testGetSubscribedEvents(): void
    {
        $expectedEvents = [ResponseEvent::class => ['onKernelResponse', -256]];
        $subscribedEvents = FlasherListener::getSubscribedEvents();

        // Verify that the FlasherListener is subscribed to the correct event and priority.
        $this->assertSame($expectedEvents, $subscribedEvents);
    }
}
