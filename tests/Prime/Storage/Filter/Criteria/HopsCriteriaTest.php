<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Storage\Filter\Criteria\HopsCriteria;
use PHPUnit\Framework\TestCase;

final class HopsCriteriaTest extends TestCase
{
    public function testConstructorWithInteger(): void
    {
        $criteria = new HopsCriteria(2);

        $this->assertInstanceOf(HopsCriteria::class, $criteria);
    }

    public function testConstructorWithArray(): void
    {
        $criteria = new HopsCriteria(['min' => 1, 'max' => 3]);

        $this->assertInstanceOf(HopsCriteria::class, $criteria);
    }

    public function testConstructorWithInvalidTypeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "hops"');

        new HopsCriteria('invalid');
    }

    public function testConstructorWithInvalidMinThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "min" in criteria "hops"');

        new HopsCriteria(['min' => 'invalid']);
    }

    public function testConstructorWithInvalidMaxThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "max" in criteria "hops"');

        new HopsCriteria(['max' => 'invalid']);
    }

    public function testApplyWithMinimumHops(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new HopsStamp(1)]),
            new Envelope(new Notification(), [new HopsStamp(2)]),
            new Envelope(new Notification(), [new HopsStamp(3)]),
        ];

        $criteria = new HopsCriteria(['min' => 2]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithMaximumHops(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new HopsStamp(1)]),
            new Envelope(new Notification(), [new HopsStamp(2)]),
            new Envelope(new Notification(), [new HopsStamp(5)]),
        ];

        $criteria = new HopsCriteria(['min' => 0, 'max' => 3]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithRange(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new HopsStamp(1)]),
            new Envelope(new Notification(), [new HopsStamp(2)]),
            new Envelope(new Notification(), [new HopsStamp(3)]),
            new Envelope(new Notification(), [new HopsStamp(5)]),
        ];

        $criteria = new HopsCriteria(['min' => 2, 'max' => 3]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithSingleValueAsMinimum(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new HopsStamp(1)]),
            new Envelope(new Notification(), [new HopsStamp(3)]),
        ];

        $criteria = new HopsCriteria(2);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyFiltersEnvelopesWithoutHopsStamp(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new HopsStamp(1)]),
            new Envelope(new Notification()),
            new Envelope(new Notification(), [new HopsStamp(2)]),
        ];

        $criteria = new HopsCriteria(['min' => 1]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testMatchReturnsTrueForMatchingHops(): void
    {
        $envelope = new Envelope(new Notification(), [new HopsStamp(2)]);

        $criteria = new HopsCriteria(['min' => 1, 'max' => 3]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testMatchReturnsFalseForNonMatchingHops(): void
    {
        $envelope = new Envelope(new Notification(), [new HopsStamp(10)]);

        $criteria = new HopsCriteria(['min' => 1, 'max' => 3]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchReturnsFalseForEnvelopeWithoutHopsStamp(): void
    {
        $envelope = new Envelope(new Notification());

        $criteria = new HopsCriteria(['min' => 1]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithHopsBelowMinimum(): void
    {
        $envelope = new Envelope(new Notification(), [new HopsStamp(1)]);

        $criteria = new HopsCriteria(['min' => 3]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithHopsAboveMaximum(): void
    {
        $envelope = new Envelope(new Notification(), [new HopsStamp(10)]);

        $criteria = new HopsCriteria(['min' => 1, 'max' => 5]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithExactBoundary(): void
    {
        $envelope = new Envelope(new Notification(), [new HopsStamp(5)]);

        $criteria = new HopsCriteria(['min' => 5, 'max' => 5]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testApplyWithEmptyArray(): void
    {
        $criteria = new HopsCriteria(['min' => 1]);

        $result = $criteria->apply([]);

        $this->assertSame([], $result);
    }

    public function testApplyWithOnlyMinInArray(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new HopsStamp(1)]),
            new Envelope(new Notification(), [new HopsStamp(5)]),
        ];

        $criteria = new HopsCriteria(['min' => 3]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithOnlyMaxInArray(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new HopsStamp(1)]),
            new Envelope(new Notification(), [new HopsStamp(5)]),
        ];

        $criteria = new HopsCriteria(['max' => 3]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithZeroHops(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new HopsStamp(0)]),
            new Envelope(new Notification(), [new HopsStamp(1)]),
        ];

        $criteria = new HopsCriteria(['min' => 0, 'max' => 0]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }
}
