<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\EnvelopeRemovalListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Tests\Prime\Helper\ObjectInvader;
use PHPUnit\Framework\TestCase;

final class RemoveListenerTest extends TestCase
{
    public function testRemoveListener(): void
    {
        $eventDispatcher = new EventDispatcher();
        ObjectInvader::from($eventDispatcher)->set('listeners', []);

        $listener = new EnvelopeRemovalListener();
        $eventDispatcher->addListener($listener);

        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification(), new HopsStamp(2)),
            new Envelope(new Notification(), new HopsStamp(1)),
            new Envelope(new Notification(), new HopsStamp(3)),
        ];
        $event = new RemoveEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $this->assertEquals([$envelopes[0], $envelopes[2]], $event->getEnvelopesToRemove());
        $this->assertEquals([$envelopes[1], $envelopes[3]], $event->getEnvelopesToKeep());
    }
}
