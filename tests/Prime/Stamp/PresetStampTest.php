<?php

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
        $stamp = new PresetStamp('entity_saved', ['resource' => 'resource']);

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }
}
