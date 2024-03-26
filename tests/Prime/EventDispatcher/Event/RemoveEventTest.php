<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use PHPUnit\Framework\TestCase;

final class RemoveEventTest extends TestCase
{
    public function testRemoveEvent(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $event = new RemoveEvent($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopesToRemove());
        $this->assertSame([], $event->getEnvelopesToKeep());

        $event->setEnvelopesToKeep([$envelopes[0], $envelopes[1]]);
        $event->setEnvelopesToRemove([$envelopes[2], $envelopes[3]]);

        $this->assertEquals([$envelopes[2], $envelopes[3]], $event->getEnvelopesToRemove());
        $this->assertEquals([$envelopes[0], $envelopes[1]], $event->getEnvelopesToKeep());
    }
}
