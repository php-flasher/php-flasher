<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\OrderableStampInterface;
use Flasher\Prime\Stamp\PresentableStampInterface;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Tests\Prime\TestCase;

final class CreatedAtStampTest extends TestCase
{
    public function testCreatedAtStamp(): void
    {
        $createdAt = new \DateTimeImmutable('2023-01-30 23:33:51');
        $stamp = new CreatedAtStamp($createdAt, 'Y-m-d H:i:s');

        $this->assertInstanceOf(StampInterface::class, $stamp);
        $this->assertInstanceOf(PresentableStampInterface::class, $stamp);
        $this->assertInstanceOf(OrderableStampInterface::class, $stamp);
        $this->assertInstanceOf('DateTimeImmutable', $stamp->getCreatedAt());
        $this->assertEquals('2023-01-30 23:33:51', $stamp->getCreatedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals(['created_at' => '2023-01-30 23:33:51'], $stamp->toArray());
    }

    public function testCompare(): void
    {
        $createdAt1 = new CreatedAtStamp(new \DateTimeImmutable('2023-01-30 23:35:49'));
        $createdAt2 = new CreatedAtStamp(new \DateTimeImmutable('2023-01-30 23:36:06'));

        $this->assertEquals(-17, $createdAt1->compare($createdAt2));
        $this->assertEquals(1, $createdAt1->compare(new HopsStamp(1)));
    }
}
