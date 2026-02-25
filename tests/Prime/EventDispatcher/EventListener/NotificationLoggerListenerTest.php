<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use PHPUnit\Framework\TestCase;

final class NotificationLoggerListenerTest extends TestCase
{
    public function testConstructorInitializesEmptyEnvelopes(): void
    {
        $listener = new NotificationLoggerListener();

        $this->assertCount(0, $listener->getDispatchedEnvelopes()->getEnvelopes());
        $this->assertCount(0, $listener->getDisplayedEnvelopes()->getEnvelopes());
    }

    public function testOnPersistLogsEnvelopes(): void
    {
        $listener = new NotificationLoggerListener();

        $notification = new Notification();
        $notification->setMessage('Test message');
        $envelope = new Envelope($notification);

        $event = new PersistEvent([$envelope]);
        $listener->onPersist($event);

        $dispatched = $listener->getDispatchedEnvelopes()->getEnvelopes();
        $this->assertCount(1, $dispatched);
        $this->assertSame($envelope, $dispatched[0]);
    }

    public function testOnPresentationLogsEnvelopes(): void
    {
        $listener = new NotificationLoggerListener();

        $notification = new Notification();
        $notification->setMessage('Test message');
        $envelope = new Envelope($notification);

        $event = new PresentationEvent([$envelope], ['html' => true]);
        $listener->onPresentation($event);

        $displayed = $listener->getDisplayedEnvelopes()->getEnvelopes();
        $this->assertCount(1, $displayed);
        $this->assertSame($envelope, $displayed[0]);
    }

    public function testInvokeWithPersistEvent(): void
    {
        $listener = new NotificationLoggerListener();

        $envelope = new Envelope(new Notification());
        $event = new PersistEvent([$envelope]);

        $listener($event);

        $this->assertCount(1, $listener->getDispatchedEnvelopes()->getEnvelopes());
    }

    public function testInvokeWithPresentationEvent(): void
    {
        $listener = new NotificationLoggerListener();

        $envelope = new Envelope(new Notification());
        $event = new PresentationEvent([$envelope], []);

        $listener($event);

        $this->assertCount(1, $listener->getDisplayedEnvelopes()->getEnvelopes());
    }

    public function testInvokeWithUnknownEvent(): void
    {
        $listener = new NotificationLoggerListener();

        $unknownEvent = new \stdClass();
        $listener($unknownEvent);

        $this->assertCount(0, $listener->getDispatchedEnvelopes()->getEnvelopes());
        $this->assertCount(0, $listener->getDisplayedEnvelopes()->getEnvelopes());
    }

    public function testReset(): void
    {
        $listener = new NotificationLoggerListener();

        // Add some envelopes
        $envelope1 = new Envelope(new Notification());
        $envelope2 = new Envelope(new Notification());

        $listener->onPersist(new PersistEvent([$envelope1]));
        $listener->onPresentation(new PresentationEvent([$envelope2], []));

        $this->assertCount(1, $listener->getDispatchedEnvelopes()->getEnvelopes());
        $this->assertCount(1, $listener->getDisplayedEnvelopes()->getEnvelopes());

        // Reset
        $listener->reset();

        $this->assertCount(0, $listener->getDispatchedEnvelopes()->getEnvelopes());
        $this->assertCount(0, $listener->getDisplayedEnvelopes()->getEnvelopes());
    }

    public function testGetSubscribedEvents(): void
    {
        $listener = new NotificationLoggerListener();

        $events = $listener->getSubscribedEvents();

        $this->assertContains(PersistEvent::class, $events);
        $this->assertContains(PresentationEvent::class, $events);
        $this->assertCount(2, $events);
    }

    public function testMultiplePersistEvents(): void
    {
        $listener = new NotificationLoggerListener();

        $envelope1 = new Envelope(new Notification());
        $envelope2 = new Envelope(new Notification());
        $envelope3 = new Envelope(new Notification());

        $listener->onPersist(new PersistEvent([$envelope1]));
        $listener->onPersist(new PersistEvent([$envelope2, $envelope3]));

        $this->assertCount(3, $listener->getDispatchedEnvelopes()->getEnvelopes());
    }

    public function testMultiplePresentationEvents(): void
    {
        $listener = new NotificationLoggerListener();

        $envelope1 = new Envelope(new Notification());
        $envelope2 = new Envelope(new Notification());

        $listener->onPresentation(new PresentationEvent([$envelope1], ['format' => 'html']));
        $listener->onPresentation(new PresentationEvent([$envelope2], ['format' => 'json']));

        $this->assertCount(2, $listener->getDisplayedEnvelopes()->getEnvelopes());
    }

    public function testEnvelopesArePreservedAfterMultipleOperations(): void
    {
        $listener = new NotificationLoggerListener();

        $notification1 = new Notification();
        $notification1->setMessage('First');
        $envelope1 = new Envelope($notification1);

        $notification2 = new Notification();
        $notification2->setMessage('Second');
        $envelope2 = new Envelope($notification2);

        $listener->onPersist(new PersistEvent([$envelope1]));
        $listener->onPersist(new PersistEvent([$envelope2]));

        $dispatched = $listener->getDispatchedEnvelopes()->getEnvelopes();

        $this->assertCount(2, $dispatched);
        $this->assertSame('First', $dispatched[0]->getMessage());
        $this->assertSame('Second', $dispatched[1]->getMessage());
    }

    public function testDispatchedAndDisplayedAreSeparate(): void
    {
        $listener = new NotificationLoggerListener();

        $dispatchedEnvelope = new Envelope(new Notification());
        $displayedEnvelope = new Envelope(new Notification());

        $listener->onPersist(new PersistEvent([$dispatchedEnvelope]));
        $listener->onPresentation(new PresentationEvent([$displayedEnvelope], []));

        $dispatched = $listener->getDispatchedEnvelopes()->getEnvelopes();
        $displayed = $listener->getDisplayedEnvelopes()->getEnvelopes();

        $this->assertSame($dispatchedEnvelope, $dispatched[0]);
        $this->assertSame($displayedEnvelope, $displayed[0]);
        $this->assertNotSame($dispatched[0], $displayed[0]);
    }
}
