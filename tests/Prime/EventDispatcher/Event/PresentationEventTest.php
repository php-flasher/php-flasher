<?php

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
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $context = [
            'livewire' => true,
        ];

        $event = new PresentationEvent($envelopes, $context);

        $this->assertEquals($envelopes, $event->getEnvelopes());
        $this->assertEquals($context, $event->getContext());
    }
}
