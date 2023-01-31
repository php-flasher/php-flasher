<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Tests\Prime\TestCase;

final class CreatedAtStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreatedAtStamp()
    {
        $createdAt = new \DateTime('2023-01-30 23:33:51');
        $stamp = new CreatedAtStamp($createdAt, 'Y-m-d H:i:s');

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertInstanceOf('Flasher\Prime\Stamp\PresentableStampInterface', $stamp);
        $this->assertInstanceOf('Flasher\Prime\Stamp\OrderableStampInterface', $stamp);
        $this->assertInstanceOf('DateTime', $stamp->getCreatedAt());
        $this->assertEquals('2023-01-30 23:33:51', $stamp->getCreatedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals(array('created_at' => '2023-01-30 23:33:51'), $stamp->toArray());
    }

    /**
     * @return void
     */
    public function testCompare()
    {
        $createdAt1 = new CreatedAtStamp(new \DateTime('2023-01-30 23:35:49'));
        $createdAt2 = new CreatedAtStamp(new \DateTime('2023-01-30 23:36:06'));

        $this->assertEquals(-17, $createdAt1->compare($createdAt2));
        $this->assertEquals(1, $createdAt1->compare(new HopsStamp(1)));
    }
}
