<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
        $rootScript = array(
            'cdn' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.0/dist/flasher.min.js',
            'local' => '/vendor/flasher/flasher.min.js',
        );

        $this->assertEquals($rootScript, $plugin->getRootScript());
    }

    /**
     * @return void
     */
    public function testGetScripts()
    {
        $plugin = new FlasherPlugin();
        $scripts = array(
            'cdn' => array('https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.0/dist/flasher.min.js'),
            'local' => array('/vendor/flasher/flasher.min.js'),
        );

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
        $mapping = array(
            'success' => array('success'),
            'error' => array('error', 'danger'),
            'warning' => array('warning', 'alarm'),
            'info' => array('info', 'notice', 'alert'),
        );

        $this->assertEquals($mapping, $plugin->getFlashBagMapping());
    }

    /**
     * @return void
     */
    public function testProcessConfiguration()
    {
        $plugin = new FlasherPlugin();
        $config = array(
            'default' => 'flasher',
            'root_script' => array(
                'cdn' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.0/dist/flasher.min.js',
                'local' => '/vendor/flasher/flasher.min.js',
            ),
            'options' => array(),
            'use_cdn' => true,
            'auto_translate' => true,
            'auto_render' => true,
            'flash_bag' => array(
                'enabled' => true,
                'mapping' => array(
                    'success' => array('success'),
                    'error' => array('error', 'danger'),
                    'warning' => array('warning', 'alarm'),
                    'info' => array('info', 'notice', 'alert'),
                ),
            ),
            'filter_criteria' => array(),
            'presets' => array(
                'created' => array(
                    'type' => 'success',
                    'message' => 'The resource was created',
                ),
                'updated' => array(
                    'type' => 'success',
                    'message' => 'The resource was updated',
                ),
                'saved' => array(
                    'type' => 'success',
                    'message' => 'The resource was saved',
                ),
                'deleted' => array(
                    'type' => 'success',
                    'message' => 'The resource was deleted',
                ),
            ),
        );

        $this->assertEquals($config, $plugin->processConfiguration());
    }

    /**
     * @return void
     */
    public function testNormalizeConfig()
    {
        $plugin = new FlasherPlugin();

        $inputConfig = array(
            'template_factory' => array(
                'default' => 'flasher',
                'templates' => array(
                    'flasher' => array(
                        'options' => array(),
                        'styles' => array(),
                    ),
                ),
            ),
            'auto_create_from_session' => true,
            'types_mapping' => array(),
            'observer_events' => array(),
            'translate_by_default' => true,
            'flash_bag' => array(),
        );

        $outputConfig = array(
            'options' => array(),
            'themes' => array(
                'flasher' => array(
                    'styles' => array(),
                ),
            ),
            'flash_bag' => array(
                'enabled' => true,
                'mapping' => array(),
            ),
            'auto_translate' => true,
            'presets' => array(
                'created' => array(
                    'type' => 'success',
                    'message' => 'The resource was created',
                ),
                'updated' => array(
                    'type' => 'success',
                    'message' => 'The resource was updated',
                ),
                'saved' => array(
                    'type' => 'success',
                    'message' => 'The resource was saved',
                ),
                'deleted' => array(
                    'type' => 'success',
                    'message' => 'The resource was deleted',
                ),
            ),
        );

        $this->assertEquals($outputConfig, $plugin->normalizeConfig($inputConfig));
    }
}
