<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Storage\Filter\Criteria\DelayCriteria;
use PHPUnit\Framework\TestCase;

final class DelayCriteriaTest extends TestCase
{
    public function testConstructorWithInteger(): void
    {
        $criteria = new DelayCriteria(5);

        $this->assertInstanceOf(DelayCriteria::class, $criteria);
    }

    public function testConstructorWithArray(): void
    {
        $criteria = new DelayCriteria(['min' => 1, 'max' => 10]);

        $this->assertInstanceOf(DelayCriteria::class, $criteria);
    }

    public function testConstructorWithInvalidTypeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "delay"');

        new DelayCriteria('invalid');
    }

    public function testConstructorWithNullThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "delay"');

        new DelayCriteria(null);
    }

    public function testConstructorWithInvalidMinThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "min" in criteria "delay"');

        new DelayCriteria(['min' => 'invalid', 'max' => 10]);
    }

    public function testConstructorWithInvalidMaxThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for "max" in criteria "delay"');

        new DelayCriteria(['min' => 1, 'max' => 'invalid']);
    }

    public function testApplyWithMinimumDelay(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(3)]),
            new Envelope(new Notification(), [new DelayStamp(7)]),
            new Envelope(new Notification(), [new DelayStamp(10)]),
        ];

        $criteria = new DelayCriteria(['min' => 5]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithMaximumDelay(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(3)]),
            new Envelope(new Notification(), [new DelayStamp(7)]),
            new Envelope(new Notification(), [new DelayStamp(10)]),
        ];

        $criteria = new DelayCriteria(['min' => 0, 'max' => 5]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithRange(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(3)]),
            new Envelope(new Notification(), [new DelayStamp(5)]),
            new Envelope(new Notification(), [new DelayStamp(7)]),
            new Envelope(new Notification(), [new DelayStamp(10)]),
        ];

        $criteria = new DelayCriteria(['min' => 4, 'max' => 8]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyWithSingleValueAsMinimum(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(3)]),
            new Envelope(new Notification(), [new DelayStamp(5)]),
            new Envelope(new Notification(), [new DelayStamp(10)]),
        ];

        $criteria = new DelayCriteria(5);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testApplyFiltersEnvelopesWithoutDelayStamp(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(5)]),
            new Envelope(new Notification()),
            new Envelope(new Notification(), [new DelayStamp(10)]),
        ];

        $criteria = new DelayCriteria(['min' => 1]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testMatchReturnsTrueForMatchingDelay(): void
    {
        $envelope = new Envelope(new Notification(), [new DelayStamp(5)]);

        $criteria = new DelayCriteria(['min' => 3, 'max' => 7]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testMatchReturnsFalseForNonMatchingDelay(): void
    {
        $envelope = new Envelope(new Notification(), [new DelayStamp(10)]);

        $criteria = new DelayCriteria(['min' => 3, 'max' => 7]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchReturnsFalseForEnvelopeWithoutDelayStamp(): void
    {
        $envelope = new Envelope(new Notification());

        $criteria = new DelayCriteria(['min' => 1]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithOnlyMinimum(): void
    {
        $envelope = new Envelope(new Notification(), [new DelayStamp(10)]);

        $criteria = new DelayCriteria(['min' => 5]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testMatchWithDelayBelowMinimum(): void
    {
        $envelope = new Envelope(new Notification(), [new DelayStamp(3)]);

        $criteria = new DelayCriteria(['min' => 5]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithDelayAboveMaximum(): void
    {
        $envelope = new Envelope(new Notification(), [new DelayStamp(15)]);

        $criteria = new DelayCriteria(['min' => 1, 'max' => 10]);

        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithExactBoundary(): void
    {
        $envelope = new Envelope(new Notification(), [new DelayStamp(5)]);

        $criteria = new DelayCriteria(['min' => 5, 'max' => 5]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testApplyWithEmptyArray(): void
    {
        $criteria = new DelayCriteria(['min' => 1]);

        $result = $criteria->apply([]);

        $this->assertSame([], $result);
    }

    public function testApplyWithOnlyMinInArray(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(3)]),
            new Envelope(new Notification(), [new DelayStamp(7)]),
        ];

        $criteria = new DelayCriteria(['min' => 5]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithOnlyMaxInArray(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(3)]),
            new Envelope(new Notification(), [new DelayStamp(7)]),
        ];

        $criteria = new DelayCriteria(['max' => 5]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testApplyWithZeroMinAndNullMax(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(0)]),
            new Envelope(new Notification(), [new DelayStamp(5)]),
            new Envelope(new Notification(), [new DelayStamp(10)]),
        ];

        $criteria = new DelayCriteria(['min' => 0, 'max' => null]);

        $result = $criteria->apply($envelopes);

        $this->assertCount(3, $result);
    }

    public function testMatchWithOnlyMaxAndNullMin(): void
    {
        // This test verifies explicit null handling for min
        // Previously relied on PHP's implicit null-to-0 coercion
        $envelope = new Envelope(new Notification(), [new DelayStamp(3)]);

        $criteria = new DelayCriteria(['max' => 5]);

        // With min=null and max=5, delay=3 should match
        $this->assertTrue($criteria->match($envelope));
    }

    public function testMatchWithOnlyMaxRejectsHigherDelay(): void
    {
        $envelope = new Envelope(new Notification(), [new DelayStamp(10)]);

        $criteria = new DelayCriteria(['max' => 5]);

        // With min=null and max=5, delay=10 should NOT match
        $this->assertFalse($criteria->match($envelope));
    }

    public function testMatchWithBothNullMinAndMax(): void
    {
        // When both min and max are null, all envelopes with delay stamp should match
        $envelope = new Envelope(new Notification(), [new DelayStamp(100)]);

        $criteria = new DelayCriteria([]);

        $this->assertTrue($criteria->match($envelope));
    }

    public function testApplyWithNullMinAndMaxMatchesAll(): void
    {
        $envelopes = [
            new Envelope(new Notification(), [new DelayStamp(0)]),
            new Envelope(new Notification(), [new DelayStamp(50)]),
            new Envelope(new Notification(), [new DelayStamp(100)]),
        ];

        $criteria = new DelayCriteria([]);

        $result = $criteria->apply($envelopes);

        // All envelopes with delay stamp should match when no constraints
        $this->assertCount(3, $result);
    }
}
