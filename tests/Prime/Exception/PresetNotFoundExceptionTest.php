<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Exception;

use Flasher\Prime\Exception\PresetNotFoundException;
use PHPUnit\Framework\TestCase;

final class PresetNotFoundExceptionTest extends TestCase
{
    public function testCreateWithPresetOnly(): void
    {
        $exception = PresetNotFoundException::create('custom_preset');

        $this->assertSame('Preset "custom_preset" not found, did you forget to register it?', $exception->getMessage());
    }

    public function testCreateWithAvailablePresets(): void
    {
        $exception = PresetNotFoundException::create('custom_preset', ['created', 'updated', 'deleted']);

        $this->assertSame('Preset "custom_preset" not found, did you forget to register it? Available presets: [created, updated, deleted]', $exception->getMessage());
    }

    public function testCreateWithEmptyAvailablePresets(): void
    {
        $exception = PresetNotFoundException::create('custom_preset', []);

        $this->assertSame('Preset "custom_preset" not found, did you forget to register it?', $exception->getMessage());
    }

    public function testIsException(): void
    {
        $exception = PresetNotFoundException::create('test');

        $this->assertInstanceOf(\Exception::class, $exception);
    }
}
