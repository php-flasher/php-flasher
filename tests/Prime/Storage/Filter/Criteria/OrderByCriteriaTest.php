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
