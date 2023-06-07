<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Tests\Prime\TestCase;

final class PresetStampTest extends TestCase
{
    public function testPresetStamp(): void
    {
        $stamp = new PresetStamp('entity_saved', ['resource' => 'resource']);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertEquals('entity_saved', $stamp->getPreset());
        $this->assertEquals(['resource' => 'resource'], $stamp->getParameters());
    }
}
