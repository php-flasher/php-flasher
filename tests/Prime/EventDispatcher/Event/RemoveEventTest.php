<?php

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

class RemoveEventTest extends TestCase
{
    /**
     * @return void
     */
    public function testRemoveEvent()
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $event = new RemoveEvent($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopesToRemove());
        $this->assertEquals([], $event->getEnvelopesToKeep());

        $event->setEnvelopesToKeep([$envelopes[0], $envelopes[1]]);
        $event->setEnvelopesToRemove([$envelopes[2], $envelopes[3]]);

        $this->assertEquals([$envelopes[2], $envelopes[3]], $event->getEnvelopesToRemove());
        $this->assertEquals([$envelopes[0], $envelopes[1]], $event->getEnvelopesToKeep());
    }
}
