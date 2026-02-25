<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Storage\Filter\Criteria\OrderByCriteria;
use PHPUnit\Framework\TestCase;

final class OrderByCriteriaTest extends TestCase
{
    public function testMultiFieldSorting(): void
    {
        $envelopes = [
            $this->createEnvelope('a', 1, new \DateTimeImmutable('2024-01-03')),
            $this->createEnvelope('b', 1, new \DateTimeImmutable('2024-01-01')),
            $this->createEnvelope('c', 1, new \DateTimeImmutable('2024-01-02')),
            $this->createEnvelope('d', 2, new \DateTimeImmutable('2024-01-01')),
        ];

        $criteria = new OrderByCriteria([
            'priority' => OrderByCriteria::ASC,
            'created_at' => OrderByCriteria::DESC,
        ]);

        $result = $criteria->apply($envelopes);

        $ids = array_map(fn (Envelope $e) => $e->getTitle(), $result);

        $this->assertSame(['a', 'c', 'b', 'd'], $ids);
    }

    public function testSingleFieldSorting(): void
    {
        $envelopes = [
            $this->createEnvelope('a', 3),
            $this->createEnvelope('b', 1),
            $this->createEnvelope('c', 2),
        ];

        $criteria = new OrderByCriteria('priority');

        $result = $criteria->apply($envelopes);

        $ids = array_map(fn (Envelope $e) => $e->getTitle(), $result);

        $this->assertSame(['b', 'c', 'a'], $ids);
    }

    public function testDescendingOrder(): void
    {
        $envelopes = [
            $this->createEnvelope('a', 1),
            $this->createEnvelope('b', 3),
            $this->createEnvelope('c', 2),
        ];

        $criteria = new OrderByCriteria(['priority' => OrderByCriteria::DESC]);

        $result = $criteria->apply($envelopes);

        $ids = array_map(fn (Envelope $e) => $e->getTitle(), $result);

        $this->assertSame(['b', 'c', 'a'], $ids);
    }

    public function testInvalidDirection(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ordering direction');

        new OrderByCriteria(['priority' => 'INVALID']);
    }

    public function testInvalidField(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('is not a valid class-string');

        new OrderByCriteria(['NonExistentStamp' => OrderByCriteria::ASC]);
    }

    public function testInvalidCriteriaType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type for criteria "order_by"');

        new OrderByCriteria(123);
    }

    public function testInvalidFieldType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Field value, must be "string"');

        // When using an integer key with an array value, $field becomes the array
        new OrderByCriteria([['not_a_string']]);
    }

    public function testInvalidDirectionType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Direction value, must be "string"');

        new OrderByCriteria(['priority' => 123]);
    }

    public function testSortingSkipsNonOrderableStamps(): void
    {
        $notification1 = new Notification();
        $notification1->setTitle('a');
        $envelope1 = new Envelope($notification1, [new PriorityStamp(1)]);

        $notification2 = new Notification();
        $notification2->setTitle('b');
        $envelope2 = new Envelope($notification2); // No OrderableStamp

        $envelopes = [$envelope1, $envelope2];

        $criteria = new OrderByCriteria(['priority' => OrderByCriteria::ASC]);
        $result = $criteria->apply($envelopes);

        $this->assertCount(2, $result);
    }

    public function testSortingWithAliases(): void
    {
        $envelopes = [
            $this->createEnvelope('a', 3, new \DateTimeImmutable('2024-01-01')),
            $this->createEnvelope('b', 1, new \DateTimeImmutable('2024-01-02')),
            $this->createEnvelope('c', 2, new \DateTimeImmutable('2024-01-03')),
        ];

        $criteria = new OrderByCriteria([
            'created_at' => OrderByCriteria::ASC,
        ]);

        $result = $criteria->apply($envelopes);
        $ids = array_map(fn (Envelope $e) => $e->getTitle(), $result);

        $this->assertSame(['a', 'b', 'c'], $ids);
    }

    public function testSortingWithSameValues(): void
    {
        $envelopes = [
            $this->createEnvelope('a', 1),
            $this->createEnvelope('b', 1),
            $this->createEnvelope('c', 1),
        ];

        $criteria = new OrderByCriteria('priority');
        $result = $criteria->apply($envelopes);

        $this->assertCount(3, $result);
    }

    public function testLowercaseDirection(): void
    {
        $envelopes = [
            $this->createEnvelope('a', 3),
            $this->createEnvelope('b', 1),
        ];

        $criteria = new OrderByCriteria(['priority' => 'asc']);
        $result = $criteria->apply($envelopes);
        $ids = array_map(fn (Envelope $e) => $e->getTitle(), $result);

        $this->assertSame(['b', 'a'], $ids);
    }

    private function createEnvelope(string $id, int $priority, ?\DateTimeImmutable $createdAt = null): Envelope
    {
        $notification = new Notification();
        $notification->setTitle($id);

        $stamps = [new PriorityStamp($priority)];

        if (null !== $createdAt) {
            $stamps[] = new CreatedAtStamp($createdAt);
        }

        return new Envelope($notification, $stamps);
    }
}
