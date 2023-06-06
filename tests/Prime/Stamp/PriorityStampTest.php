<?php

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Tests\Prime\TestCase;

final class PriorityStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testPriorityStamp()
    {
        $stamp = new PriorityStamp(5);

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertInstanceOf('Flasher\Prime\Stamp\OrderableStampInterface', $stamp);
        $this->assertInstanceOf('Flasher\Prime\Stamp\PresentableStampInterface', $stamp);
        $this->assertEquals(5, $stamp->getPriority());
        $this->assertEquals(['priority' => 5], $stamp->toArray());
    }

    /**
     * @return void
     */
    public function testCompare()
    {
        $stamp1 = new PriorityStamp(1);
        $stamp2 = new PriorityStamp(2);

        $this->assertEquals(-1, $stamp1->compare($stamp2));
        $this->assertEquals(1, $stamp1->compare(new HopsStamp(1)));
    }
}
