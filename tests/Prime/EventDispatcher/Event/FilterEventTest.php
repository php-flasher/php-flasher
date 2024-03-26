<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Storage\Filter\Filter;
use PHPUnit\Framework\TestCase;

final class FilterEventTest extends TestCase
{
    public function testFilterEvent(): void
    {
        $filter = new Filter();

        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $criteria = ['limit' => 2];

        $event = new FilterEvent($filter, $envelopes, $criteria);

        $this->assertSame($filter, $event->getFilter());
        $this->assertSame($envelopes, $event->getEnvelopes());
        $this->assertSame($criteria, $event->getCriteria());
    }
}
