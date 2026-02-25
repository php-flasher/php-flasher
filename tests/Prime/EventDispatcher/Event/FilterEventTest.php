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

    public function testSetFilter(): void
    {
        $originalFilter = new Filter();
        $newFilter = new Filter();

        $event = new FilterEvent($originalFilter, [], []);

        $this->assertSame($originalFilter, $event->getFilter());

        $event->setFilter($newFilter);

        $this->assertSame($newFilter, $event->getFilter());
    }

    public function testSetEnvelopes(): void
    {
        $originalEnvelopes = [
            new Envelope(new Notification()),
        ];

        $event = new FilterEvent(new Filter(), $originalEnvelopes, []);

        $this->assertSame($originalEnvelopes, $event->getEnvelopes());

        $newEnvelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $event->setEnvelopes($newEnvelopes);

        $this->assertSame($newEnvelopes, $event->getEnvelopes());
        $this->assertCount(2, $event->getEnvelopes());
    }

    public function testGetCriteriaWithMultipleCriteria(): void
    {
        $criteria = [
            'limit' => 5,
            'order_by' => 'priority',
            'stamps' => ['Flasher\Prime\Stamp\PriorityStamp'],
        ];

        $event = new FilterEvent(new Filter(), [], $criteria);

        $this->assertSame($criteria, $event->getCriteria());
        $this->assertSame(5, $event->getCriteria()['limit']);
        $this->assertSame('priority', $event->getCriteria()['order_by']);
    }

    public function testFilterEventWithEmptyEnvelopes(): void
    {
        $event = new FilterEvent(new Filter(), [], []);

        $this->assertSame([], $event->getEnvelopes());
        $this->assertSame([], $event->getCriteria());
    }

    public function testSetEnvelopesToEmptyArray(): void
    {
        $originalEnvelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $event = new FilterEvent(new Filter(), $originalEnvelopes, []);

        $this->assertCount(2, $event->getEnvelopes());

        $event->setEnvelopes([]);

        $this->assertSame([], $event->getEnvelopes());
        $this->assertCount(0, $event->getEnvelopes());
    }

    public function testCriteriaIsReadonly(): void
    {
        $criteria = ['limit' => 10];
        $event = new FilterEvent(new Filter(), [], $criteria);

        // Criteria cannot be changed after construction
        $retrievedCriteria = $event->getCriteria();
        $this->assertSame(10, $retrievedCriteria['limit']);
    }

    public function testFilterEventPreservesEnvelopeOrder(): void
    {
        $notification1 = new Notification();
        $notification1->setMessage('First');

        $notification2 = new Notification();
        $notification2->setMessage('Second');

        $notification3 = new Notification();
        $notification3->setMessage('Third');

        $envelopes = [
            new Envelope($notification1),
            new Envelope($notification2),
            new Envelope($notification3),
        ];

        $event = new FilterEvent(new Filter(), $envelopes, []);

        $retrievedEnvelopes = $event->getEnvelopes();
        $this->assertSame('First', $retrievedEnvelopes[0]->getMessage());
        $this->assertSame('Second', $retrievedEnvelopes[1]->getMessage());
        $this->assertSame('Third', $retrievedEnvelopes[2]->getMessage());
    }
}
