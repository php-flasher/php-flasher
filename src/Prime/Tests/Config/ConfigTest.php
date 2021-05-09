<?php

namespace Flasher\Prime\Tests\Config;

use Flasher\Prime\Config\Config;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
    public function testGet()
    {
        $config = new Config(
            array(
                'default' => 'default_flasher',
                'drivers' => array(
                    'toastr' => array(
                        'scripts' => array('script.js'),
                        'styles' => array('styles.css'),
                        'options' => array(),
                    ),
                ),
            )
        );

        $this->assertEquals('default_flasher', $config->get('default'));
        $this->assertEquals(
            array(
                'scripts' => array('script.js'),
                'styles' => array('styles.css'),
                'options' => array(),
            ),
            $config->get('drivers.toastr')
        );
        $this->assertEquals(array('styles.css'), $config->get('drivers.toastr.styles'));
        $this->assertEquals(array(), $config->get('drivers.toastr.options'));
        $this->assertEquals(null, $config->get('drivers.not_exists.options'));
        $this->assertEquals('now_it_exists', $config->get('drivers.not_exists.options', 'now_it_exists'));
    }
}
