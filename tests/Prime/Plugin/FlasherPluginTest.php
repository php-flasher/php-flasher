<?php

namespace Flasher\Tests\Prime\Plugin;

use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Tests\Prime\TestCase;

class FlasherPluginTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetName()
    {
        $plugin = new FlasherPlugin();
        $this->assertEquals('flasher', $plugin->getName());
    }

    /**
     * @return void
     */
    public function testGetServiceID()
    {
        $plugin = new FlasherPlugin();
        $this->assertEquals('flasher', $plugin->getServiceID());
    }

    /**
     * @return void
     */
    public function testGetDefault()
    {
        $plugin = new FlasherPlugin();
        $this->assertEquals('flasher', $plugin->getDefault());
    }

    /**
     * @return void
     */
    public function testGetRootScript()
    {
        $plugin = new FlasherPlugin();
        $rootScript = [
            'cdn' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js',
            'local' => '/vendor/flasher/flasher.min.js',
        ];

        $this->assertEquals($rootScript, $plugin->getRootScript());
    }

    /**
     * @return void
     */
    public function testGetScripts()
    {
        $plugin = new FlasherPlugin();
        $scripts = [
            'cdn' => ['https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js'],
            'local' => ['/vendor/flasher/flasher.min.js'],
        ];

        $this->assertEquals($scripts, $plugin->getScripts());
    }

    /**
     * @return void
     */
    public function testGetResourcesDir()
    {
        $plugin = new FlasherPlugin();
        $resourceDir = realpath(__DIR__.'/../../../src/Prime/Resources');

        $this->assertEquals($resourceDir, $plugin->getResourcesDir());
    }

    /**
     * @return void
     */
    public function testGetFlashBagMapping()
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

    /**
     * @return void
     */
    public function testProcessConfiguration()
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

    /**
     * @return void
     */
    public function testNormalizeConfig()
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
