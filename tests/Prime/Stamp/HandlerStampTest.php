<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Tests\Prime\TestCase;

final class HandlerStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testHandlerStamp()
    {
        $stamp = new HandlerStamp('toastr');

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertInstanceOf('Flasher\Prime\Stamp\PresentableStampInterface', $stamp);
        $this->assertEquals('toastr', $stamp->getHandler());
        $this->assertEquals(array('handler' => 'toastr'), $stamp->toArray());
    }
}
