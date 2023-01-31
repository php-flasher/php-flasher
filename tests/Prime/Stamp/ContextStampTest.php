<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Tests\Prime\TestCase;

class ContextStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testContextStamp()
    {
        $stamp = new ContextStamp(array('component' => 'livewire'));

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertInstanceOf('Flasher\Prime\Stamp\PresentableStampInterface', $stamp);
        $this->assertEquals(array('component' => 'livewire'), $stamp->getContext());
        $this->assertEquals(array('context' => array('component' => 'livewire')), $stamp->toArray());
    }
}
