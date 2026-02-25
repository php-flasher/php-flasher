<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Storage\Filter\Criteria\PriorityCriteria;
use PHPUnit\Framework\TestCase;

final class PriorityCriteriaTest extends TestCase
{
    public function testConstructorWithInteger(): void
    {
        $criteria = new PriorityCriteria(5);

        $this->assertInstanceOf(PriorityCriteria::class, $criteria);
    }

    public function testConstructorWithArray(): void
    {
        $criteria = new PriorityCriteria(['min' => 1, 'max' => 10]);

        $this->assertInstanceOf(PriorityCriteria::class, $criteria);
    }

    public function testConstructorWithInvalidTypeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "priority"');

        new PriorityCriteria('invalid');
    }

    public function testConstructorWithInvalidMinThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "min" in criteria "priority"');

        new PriorityCriteria(['min' => 'invalid']);
    }

    public function testConstructorWithInvalidMaxThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "max" in criteria "priority"');

        new PriorityCriteria(['max' => 'invalid']);
    }

    public function testApplyWithMinimumPriority(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(3)]),
            new Envelope(new Notification(), [new PriorityStamp(7)]),
            new Envelope(new Notification(), [new PriorityStamp(10)]),
        ];

        $criteria = new PriorityCriteria(['min' => 5]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithMaximumPriority(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(3)]),
            new Envelope(new Notification(), [new PriorityStamp(7)]),
            new Envelope(new Notification(), [new PriorityStamp(10)]),
        ];

        $criteria = new PriorityCriteria(['min' => 0, 'max' => 5]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithRange(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(1)]),
            new Envelope(new Notification(), [new PriorityStamp(5)]),
            new Envelope(new Notification(), [new PriorityStamp(7)]),
            new Envelope(new Notification(), [new PriorityStamp(10)]),
        ];

        $criteria = new PriorityCriteria(['min' => 3, 'max' => 8]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithSingleValueAsMinimum(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(3)]),
            new Envelope(new Notification(), [new PriorityStamp(5)]),
            new Envelope(new Notification(), [new PriorityStamp(10)]),
        ];

        $criteria = new PriorityCriteria(5);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyFiltersEnvelopesWithoutPriorityStamp(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(5)]),
            new Envelope(new Notification()),
            new Envelope(new Notification(), [new PriorityStamp(10)]),
        ];

        $criteria = new PriorityCriteria(['min' => 1]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testMatchReturnsTrueForMatchingPriority(): void
    {
        $envelope = new Envelope(new Notification(), [new PriorityStamp(5)]);

        $criteria = new PriorityCriteria(['min' => 3, 'max' => 7]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testMatchReturnsFalseForNonMatchingPriority(): void
    {
        $envelope = new Envelope(new Notification(), [new PriorityStamp(10)]);

        $criteria = new PriorityCriteria(['min' => 3, 'max' => 7]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchReturnsFalseForEnvelopeWithoutPriorityStamp(): void
    {
        $envelope = new Envelope(new Notification());

        $criteria = new PriorityCriteria(['min' => 1]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithPriorityBelowMinimum(): void
    {
        $envelope = new Envelope(new Notification(), [new PriorityStamp(3)]);

        $criteria = new PriorityCriteria(['min' => 5]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithPriorityAboveMaximum(): void
    {
        $envelope = new Envelope(new Notification(), [new PriorityStamp(15)]);

        $criteria = new PriorityCriteria(['min' => 1, 'max' => 10]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithExactBoundary(): void
    {
        $envelope = new Envelope(new Notification(), [new PriorityStamp(5)]);

        $criteria = new PriorityCriteria(['min' => 5, 'max' => 5]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testApplyWithEmptyArray(): void
    {
        $criteria = new PriorityCriteria(['min' => 1]);

        $result = $criteria->apply([]);

        $this->assertSame([], $result);
    }

    public function testApplyWithOnlyMinInArray(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(3)]),
            new Envelope(new Notification(), [new PriorityStamp(7)]),
        ];

        $criteria = new PriorityCriteria(['min' => 5]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithOnlyMaxInArray(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(3)]),
            new Envelope(new Notification(), [new PriorityStamp(7)]),
        ];

        $criteria = new PriorityCriteria(['max' => 5]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithNegativePriority(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(-5)]),
            new Envelope(new Notification(), [new PriorityStamp(0)]),
            new Envelope(new Notification(), [new PriorityStamp(5)]),
        ];

        $criteria = new PriorityCriteria(['min' => -10, 'max' => 0]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithZeroPriority(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new PriorityStamp(0)]),
            new Envelope(new Notification(), [new PriorityStamp(1)]),
        ];

        $criteria = new PriorityCriteria(['min' => 0, 'max' => 0]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }
}
