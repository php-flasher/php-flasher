<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Config;

use Flasher\Prime\Config\Config;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
    /**
     * @return void
     */
    public function testGet()
    {
        /** @phpstan-ignore-next-line */
        $config = new Config(array(
            'default' => 'flasher',
            'root_script' => 'flasher.min.js',
            'themes' => array(
                'flasher' => array(
                    'scripts' => array('script.js'),
                    'styles' => array('styles.css'),
                    'options' => array(),
                ),
            ),
            'auto_translate' => true,
            'flash_bag' => array(
                'enabled' => true,
                'mapping' => array(
                    'success' => array('success'),
                    'error' => array('error'),
                ),
            ),
            'presets' => array(
                'success' => array(
                    'type' => 'success',
                    'title' => 'Success',
                    'message' => 'Success message',
                    'options' => array(),
                ),
                'error' => array(
                    'type' => 'error',
                    'title' => 'Error',
                    'message' => 'Error message',
                    'options' => array(),
                ),
            ),
        ));

        $this->assertEquals('flasher', $config->get('default'));
        $this->assertEquals(array(
            'scripts' => array('script.js'),
            'styles' => array('styles.css'),
            'options' => array(),
        ), $config->get('themes.flasher'));
        $this->assertEquals(array('styles.css'), $config->get('themes.flasher.styles'));
        $this->assertEquals(array(), $config->get('themes.flasher.options'));
        $this->assertNull($config->get('drivers.not_exists.options'));
        $this->assertEquals('now_it_exists', $config->get('drivers.not_exists.options', 'now_it_exists'));
    }
}
