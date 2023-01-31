<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Tests\Prime\TestCase;

class UnlessStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testUnlessStamp()
    {
        $stamp = new UnlessStamp(true);

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertTrue($stamp->getCondition());
    }
}
