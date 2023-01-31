<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

class PresentationEventTest extends TestCase
{
    /**
     * @return void
     */
    public function testPresentationEvent()
    {
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $context = array(
            'livewire' => true,
        );

        $event = new PresentationEvent($envelopes, $context);

        $this->assertEquals($envelopes, $event->getEnvelopes());
        $this->assertEquals($context, $event->getContext());
    }
}
