<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Storage\Filter\Criteria\StampsCriteria;
use PHPUnit\Framework\TestCase;

final class StampsCriteriaTest extends TestCase
{
    public function testMatchWithAndStrategy(): void
    {
        $notification = new Notification();
        $envelopeWithBothStamps = new Envelope($notification, [
            new HopsStamp(1),
            new PriorityStamp(5),
        ]);
        $envelopeWithOneStamp = new Envelope($notification, [
            new HopsStamp(1),
        ]);
        $envelopeWithNoStamps = new Envelope($notification);

        $criteria = new StampsCriteria([
            HopsStamp::class => true,
            PriorityStamp::class => true,
        ], StampsCriteria::STRATEGY_AND);

        $this->assertTrue($criteria->match($envelopeWithBothStamps));
        $this->assertFalse($criteria->match($envelopeWithOneStamp));
        $this->assertFalse($criteria->match($envelopeWithNoStamps));
    }

    public function testMatchWithOrStrategy(): void
    {
        $notification = new Notification();
        $envelopeWithBothStamps = new Envelope($notification, [
            new HopsStamp(1),
            new PriorityStamp(5),
        ]);
        $envelopeWithOneStamp = new Envelope($notification, [
            new HopsStamp(1),
        ]);
        $envelopeWithNoStamps = new Envelope($notification);

        $criteria = new StampsCriteria([
            HopsStamp::class => true,
            PriorityStamp::class => true,
        ], StampsCriteria::STRATEGY_OR);

        $this->assertTrue($criteria->match($envelopeWithBothStamps));
        $this->assertTrue($criteria->match($envelopeWithOneStamp));
        $this->assertFalse($criteria->match($envelopeWithNoStamps));
    }

    public function testApplyFiltersEnvelopes(): void
    {
        $notification = new Notification();
        $envelopes = [
            new Envelope($notification, [new HopsStamp(1)]),
            new Envelope($notification, [new PriorityStamp(5)]),
            new Envelope($notification, [new HopsStamp(1), new PriorityStamp(5)]),
            new Envelope($notification),
        ];

        $criteria = new StampsCriteria([HopsStamp::class => true]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testInvalidCriteriaType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for criteria 'stamps'");

        new StampsCriteria('invalid');
    }

    public function testOrStrategyWithNoMatches(): void
    {
        $notification = new Notification();
        $envelope = new Envelope($notification);

        $criteria = new StampsCriteria([
            HopsStamp::class => true,
        ], StampsCriteria::STRATEGY_OR);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testDefaultAndStrategy(): void
    {
        $notification = new Notification();
        $envelope = new Envelope($notification, [
            new HopsStamp(1),
        ]);

        $criteria = new StampsCriteria([
            HopsStamp::class => true,
        ]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testEmptyStamps(): void
    {
        $notification = new Notification();
        $envelope = new Envelope($notification);

        $criteria = new StampsCriteria([]);

        $this->assertTrue($criteria->match($envelope));
    }
}
