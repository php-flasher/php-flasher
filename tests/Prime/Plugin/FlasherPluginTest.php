<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Plugin;

use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Tests\Prime\TestCase;

final class FlasherPluginTest extends TestCase
{
    public function testGetName(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertEquals('flasher', $plugin->getName());
    }

    public function testGetServiceID(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertEquals('flasher', $plugin->getServiceId());
    }

    public function testGetDefault(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertEquals('flasher', $plugin->getDefault());
    }

    public function testGetRootScript(): void
    {
        $plugin = new FlasherPlugin();
        $rootScript = 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js';

        $this->assertEquals($rootScript, $plugin->getRootScript());
    }

    public function testGetScripts(): void
    {
        $plugin = new FlasherPlugin();

        $this->assertEquals([], $plugin->getScripts());
    }

    public function testProcessConfiguration(): void
    {
        $plugin = new FlasherPlugin();
        $config = [
            'default' => 'flasher',
            'root_script' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js',
            'scripts' => [],
            'styles' => ['https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.css'],
            'options' => [],
            'translate' => true,
            'inject_assets' => true,
            'flash_bag' => [],
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
                    'styles' => ['https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.css'],
                    'options' => [],
                ],
            ],
            'filter' => [],
        ];

        $this->assertEquals($config, $plugin->normalizeConfig());
    }
}
