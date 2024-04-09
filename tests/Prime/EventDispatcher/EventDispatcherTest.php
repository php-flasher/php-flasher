<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Tests\Prime\Fixtures\EventDispatcher\Event\InvokeableEvent;
use Flasher\Tests\Prime\Fixtures\EventDispatcher\Event\StoppableEvent;
use Flasher\Tests\Prime\Fixtures\EventDispatcher\EventListener\InvokeableEventListener;
use Flasher\Tests\Prime\Fixtures\EventDispatcher\EventListener\NonCallableListener;
use Flasher\Tests\Prime\Fixtures\EventDispatcher\EventListener\StoppableEventListener;
use PHPUnit\Framework\TestCase;

final class EventDispatcherTest extends TestCase
{
    private EventDispatcher $dispatcher;

    protected function setUp(): void
    {
        $this->dispatcher = new EventDispatcher();
    }

    public function testInitialState(): void
    {
        $dispatcher = new EventDispatcher();
        $this->assertSame([], $dispatcher->getListeners('fake_event'));
    }

    public function testAddAndRetrieveListeners(): void
    {
        $listener = $this->createMock(EventListenerInterface::class);
        $listener->method('getSubscribedEvents')
            ->willReturn(['some_event']);

        $this->dispatcher->addListener($listener);

        $listeners = $this->dispatcher->getListeners('some_event');
        $this->assertCount(1, $listeners);
        $this->assertSame($listener, $listeners[0]);
    }

    public function testDispatchCallsListeners(): void
    {
        $event = new InvokeableEvent();
        $listener = new InvokeableEventListener();

        $this->dispatcher->addListener($listener);
        $this->dispatcher->dispatch($event);

        $this->assertTrue($event->isInvoked());
    }

    public function testDispatchWithStoppableEvent(): void
    {
        $event = new StoppableEvent();
        $listener = new StoppableEventListener();

        $this->dispatcher->addListener($listener);
        $this->dispatcher->dispatch($event);

        $this->assertTrue($event->isPropagationStopped());
    }

    public function testDispatchWithNonCallableListener(): void
    {
        $event = new class() {};
        $eventName = $event::class;

        $listener = new NonCallableListener($eventName);

        $this->dispatcher->addListener($listener);

        $this->expectException(\InvalidArgumentException::class);
        $this->dispatcher->dispatch($event);
    }

    public function testMultipleListenersForSingleEvent(): void
    {
        $event = new InvokeableEvent();
        $listener1 = new InvokeableEventListener();
        $listener2 = new InvokeableEventListener();

        $this->dispatcher->addListener($listener1);
        $this->dispatcher->addListener($listener2);
        $this->dispatcher->dispatch($event);

        $this->assertSame(2, $event->getInvokeCount());
    }

    public function testMultipleListenersForStoppableEvent(): void
    {
        $event = new InvokeableEvent();
        $listener1 = new StoppableEventListener();
        $listener2 = new InvokeableEventListener();

        $this->dispatcher->addListener($listener1);
        $this->dispatcher->addListener($listener2);
        $this->dispatcher->dispatch($event);

        $this->assertTrue($event->isInvoked());
        $this->assertSame(1, $event->getInvokeCount());
    }

    public function testDispatchEventWithNoListeners(): void
    {
        $event = new InvokeableEvent();
        $this->dispatcher->dispatch($event);

        $this->assertFalse($event->isInvoked());
    }
}
