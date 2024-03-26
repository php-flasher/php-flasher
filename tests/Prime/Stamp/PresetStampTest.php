<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\PresetStamp;
use PHPUnit\Framework\TestCase;

final class PresetStampTest extends TestCase
{
    /**
     * getPreset method test.
     *
     * This test case focuses on the proper retrieval of the preset value from the PresetStamp class.
     */
    public function testGetPreset(): void
    {
        $preset = 'preset_value';
        $parameters = ['parameter1' => 'value1'];

        $presetStamp = new PresetStamp($preset, $parameters);

        $this->assertSame($preset, $presetStamp->getPreset());
    }

    /**
     * getParameters method test.
     *
     * This test case focuses on the proper retrieval of parameters from the PresetStamp class.
     */
    public function testGetParameters(): void
    {
        $preset = 'preset_value';
        $parameters = ['parameter1' => 'value1'];

        $presetStamp = new PresetStamp($preset, $parameters);

        $this->assertSame($parameters, $presetStamp->getParameters());
    }
}
