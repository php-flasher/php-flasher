<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Plugin;

use Flasher\Prime\Plugin\FlasherPlugin;
use PHPUnit\Framework\TestCase;

final class FlasherPluginTest extends TestCase
{
    public function testGetName(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame('flasher', $plugin->getName());
    }

    public function testGetServiceID(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame('flasher', $plugin->getServiceId());
    }

    public function testGetDefault(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertSame('flasher', $plugin->getDefault());
    }

    public function testGetRootScript(): void
    {
        $plugin = new FlasherPlugin();
        $rootScript = '/vendor/flasher/flasher.min.js';

        $this->assertSame($rootScript, $plugin->getRootScript());
    }

    public function testGetScripts(): void
    {
        $plugin = new FlasherPlugin();

        $this->assertSame([], $plugin->getScripts());
    }

    public function testProcessConfiguration(): void
    {
        $plugin = new FlasherPlugin();
        $config = [
            'default' => 'flasher',
            'main_script' => '/vendor/flasher/flasher.min.js',
            'scripts' => [],
            'styles' => ['/vendor/flasher/flasher.min.css'],
            'options' => [],
            'translate' => true,
            'inject_assets' => true,
            'flash_bag' => [
                'success' => ['success'],
                'error' => ['error', 'danger'],
                'warning' => ['warning', 'alarm'],
                'info' => ['info', 'notice', 'alert'],
            ],
            'presets' => [
                'created' => [
                    'type' => 'success',
                    'message' => 'The resource was created',
                    'options' => [],
                ],
                'updated' => [
                    'type' => 'success',
                    'message' => 'The resource was updated',
                    'options' => [],
                ],
                'saved' => [
                    'type' => 'success',
                    'message' => 'The resource was saved',
                    'options' => [],
                ],
                'deleted' => [
                    'type' => 'success',
                    'message' => 'The resource was deleted',
                    'options' => [],
                ],
            ],
            'plugins' => [
                'flasher' => [
                    'scripts' => [],
                    'styles' => ['/vendor/flasher/flasher.min.css'],
                    'options' => [],
                ],
            ],
            'filter' => [],
        ];

        $this->assertEquals($config, $plugin->normalizeConfig());
    }
}
