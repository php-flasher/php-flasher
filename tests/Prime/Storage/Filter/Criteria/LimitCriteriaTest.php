<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Storage\Filter\Criteria\LimitCriteria;
use PHPUnit\Framework\TestCase;

final class LimitCriteriaTest extends TestCase
{
    public function testLimitToSpecificCount(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $criteria = new LimitCriteria(2);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testLimitPreservesKeys(): void
    {
        $envelopes = [
            'first' => new Envelope(new Notification()),
            'second' => new Envelope(new Notification()),
            'third' => new Envelope(new Notification()),
        ];

        $criteria = new LimitCriteria(2);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
        $this->assertArrayHasKey('first', $result);
        $this->assertArrayHasKey('second', $result);
        $this->assertArrayNotHasKey('third', $result);
    }

    public function testLimitGreaterThanArraySize(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $criteria = new LimitCriteria(10);

        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testLimitZeroThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Criteria 'limit' must be a positive integer (>= 1).");

        new LimitCriteria(0);
    }

    public function testEmptyArrayReturnsEmpty(): void
    {
        $criteria = new LimitCriteria(5);

        $result = $criteria->apply([]);

        $this->assertCount(0, $result);
    }

    public function testInvalidCriteriaTypeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for criteria 'limit'.");

        new LimitCriteria('not an integer');
    }

    public function testInvalidCriteriaNullThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for criteria 'limit'.");

        new LimitCriteria(null);
    }

    public function testInvalidCriteriaArrayThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid type for criteria 'limit'.");

        new LimitCriteria([]);
    }

    public function testLimitOneReturnsSingleElement(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $criteria = new LimitCriteria(1);

        $result = $criteria->apply($envelopes);

        $this->assertCount(1, $result);
    }

    public function testNegativeLimitThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Criteria 'limit' must be a positive integer (>= 1).");

        new LimitCriteria(-5);
    }
}
