<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use PHPUnit\Framework\TestCase;

final class PersistEventTest extends TestCase
{
    public function testPersistEvent(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $event = new PersistEvent($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopes());

        $envelopes = [
            new Envelope(new Notification()),
        ];
        $event->setEnvelopes($envelopes);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }
}
