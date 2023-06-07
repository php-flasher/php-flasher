<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\Filter\Filter;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

final class FilterEventTest extends TestCase
{
    public function testFilterEvent(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $event = new FilterEvent($envelopes, ['limit' => 2]);

        $this->assertInstanceOf(\Flasher\Prime\Filter\Filter::class, $event->getFilter());
        $this->assertEquals([$envelopes[0], $envelopes[1]], $event->getEnvelopes());

        $filter = new Filter($envelopes, []);
        $event->setFilter($filter);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }
}
