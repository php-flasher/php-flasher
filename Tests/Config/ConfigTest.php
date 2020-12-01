<?php

namespace Flasher\Prime\Tests\Config;

use Notify\Config\Config;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
    public function testGet()
    {
        $config = new Config(
            array(
                'default' => 'notify',
                'drivers' => array(
                    'notify' => array(
                        'scripts' => array('script.js'),
                        'styles'  => array('styles.css'),
                        'options' => array()
                    )
                ),
            )
        );

        $this->assertEquals('notify', $config->get('default'));
        $this->assertEquals(
            array(
                'scripts' => array('script.js'),
                'styles'  => array('styles.css'),
                'options' => array()
            ),
            $config->get('drivers.notify')
        );
        $this->assertEquals(array('styles.css'), $config->get('drivers.notify.styles'));
        $this->assertEquals(array(), $config->get('drivers.notify.options'));
        $this->assertEquals(null, $config->get('drivers.not_exists.options'));
        $this->assertEquals('now_it_exists', $config->get('drivers.not_exists.options', 'now_it_exists'));
    }
}
