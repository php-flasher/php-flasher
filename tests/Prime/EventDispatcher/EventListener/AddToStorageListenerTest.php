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
use Flasher\Tests\Prime\Helper\ObjectInvader;
use PHPUnit\Framework\TestCase;

final class AddToStorageListenerTest extends TestCase
{
    public function testAddToStorageListener(): void
    {
        $eventDispatcher = new EventDispatcher();

        ObjectInvader::from($eventDispatcher)->set('listeners', []);

        $listener = new AddToStorageListener();
        $eventDispatcher->addListener($listener);

        $envelopes = [
            new Envelope(new Notification(), new WhenStamp(false)),
            new Envelope(new Notification()),
            new Envelope(new Notification(), new UnlessStamp(true)),
            new Envelope(new Notification()),
        ];

        $event = new PersistEvent($envelopes);
        $eventDispatcher->dispatch($event);

        $this->assertCount(2, $event->getEnvelopes());
    }
}
