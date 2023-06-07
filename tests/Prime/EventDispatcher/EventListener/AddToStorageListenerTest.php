<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\AddToStorageListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;
use Flasher\Tests\Prime\TestCase;

final class AddToStorageListenerTest extends TestCase
{
    public function testAddToStorageListener(): void
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', []);

        $listener = new AddToStorageListener();
        $eventDispatcher->addSubscriber($listener);

        $envelopes = [
            new Envelope(new Notification(), new WhenStamp(false)),
            new Envelope(new Notification()),
            new Envelope(new Notification(), new UnlessStamp(true)),
            new Envelope(new Notification()),
        ];
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $this->assertEquals([$envelopes[1], $envelopes[3]], $event->getEnvelopes());
    }
}
