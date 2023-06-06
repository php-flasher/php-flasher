<?php

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Tests\Prime\TestCase;

final class HopsStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testHopsStamp()
    {
        $stamp = new HopsStamp(5);

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertEquals(5, $stamp->getAmount());
    }
}
