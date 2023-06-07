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
        $this->assertEquals('flasher', $plugin->getServiceID());
    }

    public function testGetDefault(): void
    {
        $plugin = new FlasherPlugin();
        $this->assertEquals('flasher', $plugin->getDefault());
    }

    public function testGetRootScript(): void
    {
        $plugin = new FlasherPlugin();
        $rootScript = [
            'cdn' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js',
            'local' => '/vendor/flasher/flasher.min.js',
        ];

        $this->assertEquals($rootScript, $plugin->getRootScript());
    }

    public function testGetScripts(): void
    {
        $plugin = new FlasherPlugin();
        $scripts = [
            'cdn' => ['https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js'],
            'local' => ['/vendor/flasher/flasher.min.js'],
        ];

        $this->assertEquals($scripts, $plugin->getScripts());
    }

    public function testGetResourcesDir(): void
    {
        $plugin = new FlasherPlugin();
        $resourceDir = realpath(__DIR__.'/../../../src/Prime/Resources');

        $this->assertEquals($resourceDir, $plugin->getResourcesDir());
    }

    public function testGetFlashBagMapping(): void
    {
        $plugin = new FlasherPlugin();
        $mapping = [
            'success' => ['success'],
            'error' => ['error', 'danger'],
            'warning' => ['warning', 'alarm'],
            'info' => ['info', 'notice', 'alert'],
        ];

        $this->assertEquals($mapping, $plugin->getFlashBagMapping());
    }

    public function testProcessConfiguration(): void
    {
        $plugin = new FlasherPlugin();
        $config = [
            'default' => 'flasher',
            'root_script' => [
                'cdn' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js',
                'local' => '/vendor/flasher/flasher.min.js',
            ],
            'scripts' => [],
            'styles' => [
                'cdn' => ['https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.css'],
                'local' => ['/vendor/flasher/flasher.min.css'],
            ],
            'options' => [],
            'use_cdn' => true,
            'auto_translate' => true,
            'auto_render' => true,
            'flash_bag' => [
                'enabled' => true,
                'mapping' => [
                    'success' => ['success'],
                    'error' => ['error', 'danger'],
                    'warning' => ['warning', 'alarm'],
                    'info' => ['info', 'notice', 'alert'],
                ],
            ],
            'filter_criteria' => [],
            'presets' => [
                'created' => [
                    'type' => 'success',
                    'message' => 'The resource was created',
                ],
                'updated' => [
                    'type' => 'success',
                    'message' => 'The resource was updated',
                ],
                'saved' => [
                    'type' => 'success',
                    'message' => 'The resource was saved',
                ],
                'deleted' => [
                    'type' => 'success',
                    'message' => 'The resource was deleted',
                ],
            ],
        ];

        $this->assertEquals($config, $plugin->processConfiguration());
    }

    public function testNormalizeConfig(): void
    {
        $plugin = new FlasherPlugin();

        $inputConfig = [
            'template_factory' => [
                'default' => 'flasher',
                'templates' => [
                    'flasher' => [
                        'options' => [],
                        'styles' => [],
                    ],
                ],
            ],
            'auto_create_from_session' => true,
            'types_mapping' => [],
            'observer_events' => [],
            'translate_by_default' => true,
            'flash_bag' => [],
        ];

        $outputConfig = [
            'options' => [],
            'themes' => [
                'flasher' => [
                    'styles' => [],
                ],
            ],
            'flash_bag' => [
                'enabled' => true,
                'mapping' => [],
            ],
            'auto_translate' => true,
            'presets' => [
                'created' => [
                    'type' => 'success',
                    'message' => 'The resource was created',
                ],
                'updated' => [
                    'type' => 'success',
                    'message' => 'The resource was updated',
                ],
                'saved' => [
                    'type' => 'success',
                    'message' => 'The resource was saved',
                ],
                'deleted' => [
                    'type' => 'success',
                    'message' => 'The resource was deleted',
                ],
            ],
        ];

        $this->assertEquals($outputConfig, $plugin->normalizeConfig($inputConfig));
    }
}
