<?php

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\WhenStamp;
use Flasher\Tests\Prime\TestCase;

class WhenStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testWhenStamp()
    {
        $stamp = new WhenStamp(true);

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertTrue($stamp->getCondition());
    }
}
