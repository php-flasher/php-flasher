<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\UpdateEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

class UpdateEventTest extends TestCase
{
    /**
     * @return void
     */
    public function testUpdateEvent()
    {
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $event = new UpdateEvent($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopes());

        $envelopes = array(
            new Envelope(new Notification()),
        );
        $event->setEnvelopes($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }
}
