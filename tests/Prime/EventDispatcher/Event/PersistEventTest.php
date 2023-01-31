<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

class PersistEventTest extends TestCase
{
    /**
     * @return void
     */
    public function testPersistEvent()
    {
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $event = new PersistEvent($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopes());

        $envelopes = array(
            new Envelope(new Notification()),
        );
        $event->setEnvelopes($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }
}
