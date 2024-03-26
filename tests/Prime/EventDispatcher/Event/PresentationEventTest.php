<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use PHPUnit\Framework\TestCase;

final class PresentationEventTest extends TestCase
{
    public function testPresentationEvent(): void
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
