<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Config;

use Flasher\Prime\Config\Config;
use Flasher\Tests\Prime\TestCase;

final class ConfigTest extends TestCase
{
    public function testGet(): void
    {
        /** @phpstan-ignore-next-line */
        $config = new Config([
            'default' => 'flasher',
            'root_script' => 'flasher.min.js',
            'themes' => [
                'flasher' => [
                    'scripts' => ['script.js'],
                    'styles' => ['styles.css'],
                    'options' => [],
                ],
            ],
            'auto_translate' => true,
            'flash_bag' => [
                'enabled' => true,
                'mapping' => [
                    'success' => ['success'],
                    'error' => ['error'],
                ],
            ],
            'presets' => [
                'success' => [
                    'type' => 'success',
                    'title' => 'Success',
                    'message' => 'Success message',
                    'options' => [],
                ],
                'error' => [
                    'type' => 'error',
                    'title' => 'Error',
                    'message' => 'Error message',
                    'options' => [],
                ],
            ],
        ]);

        $this->assertEquals('flasher', $config->get('default'));
        $this->assertEquals([
            'scripts' => ['script.js'],
            'styles' => ['styles.css'],
            'options' => [],
        ], $config->get('themes.flasher'));
        $this->assertEquals(['styles.css'], $config->get('themes.flasher.styles'));
        $this->assertEquals(['script.js'], $config->get('themes.flasher.scripts'));
        $this->assertEquals([], $config->get('themes.flasher.options'));
        $this->assertNull($config->get('drivers.not_exists.options'));
        $this->assertEquals('now_it_exists', $config->get('drivers.not_exists.options', 'now_it_exists'));
    }
}
