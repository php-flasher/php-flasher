<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $event = new RemoveEvent($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopesToRemove());
        $this->assertEquals(array(), $event->getEnvelopesToKeep());

        $event->setEnvelopesToKeep(array($envelopes[0], $envelopes[1]));
        $event->setEnvelopesToRemove(array($envelopes[2], $envelopes[3]));

        $this->assertEquals(array($envelopes[2], $envelopes[3]), $event->getEnvelopesToRemove());
        $this->assertEquals(array($envelopes[0], $envelopes[1]), $event->getEnvelopesToKeep());
    }
}
