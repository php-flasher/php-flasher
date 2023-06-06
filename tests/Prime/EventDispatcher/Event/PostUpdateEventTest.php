<?php

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\PostUpdateEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

class PostUpdateEventTest extends TestCase
{
    /**
     * @return void
     */
    public function testPostUpdateEvent()
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $event = new PostUpdateEvent($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }
}
