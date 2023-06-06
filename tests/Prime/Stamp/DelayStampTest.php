<?php

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Tests\Prime\TestCase;

class DelayStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testDelayStamp()
    {
        $stamp = new DelayStamp(2);

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertEquals(2, $stamp->getDelay());
    }
}
