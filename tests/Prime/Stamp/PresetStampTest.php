<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Tests\Prime\TestCase;

class PresetStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testPresetStamp()
    {
        $stamp = new PresetStamp('entity_saved', array('resource' => 'resource'));

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals(array('resource' => 'resource'), $stamp->getParameters());
    }
}
