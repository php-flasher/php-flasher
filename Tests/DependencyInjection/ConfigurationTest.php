<?php

namespace Flasher\Symfony\Tests\DependencyInjection;

use Flasher\Prime\Tests\TestCase;
use Flasher\Symfony\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $config = $this->process(array());

        $expected = array(
            'scripts' => array(
                '/bundles/flasher/flasher.js',
            ),
            'styles' => array(),
            'auto_create_from_session' => true,
            'types_mapping' => array(
                'success' => array('success'),
                'error'   => array('error', 'danger'),
                'warning' => array('warning', 'alarm'),
                'info'    => array('info', 'notice', 'alert'),
            ),
            'adapters' => array(),
        );

        $this->assertSame($expected, $config);
    }

    public function testSimpleConfig()
    {
        $config = $this->process(array(array(
            'default' => 'notyf',
            'adapters' => array(
                'notyf' => array(
                    'scripts' => array(
                        'jquery.js',
                        'notyf.js'
                    ),
                    'styles' => array(
                        'notyf.css'
                    ),
                    'options' => array(
                        'timeout' => 5000,
                        'position' => 'top-right'
                    )
                )
            ),
            'scripts' => array(),
            'styles' => array(
               '/bundles/flasher/flasher.css',
            )
        )));

        $expected = array(
            'default' => 'notyf',
            'scripts' => array(),
            'styles' => array(
               '/bundles/flasher/flasher.css',
            ),
            'auto_create_from_session' => true,
            'types_mapping' => array(
                'success' => array('success'),
                'error'   => array('error', 'danger'),
                'warning' => array('warning', 'alarm'),
                'info'    => array('info', 'notice', 'alert'),
            ),
            'adapters' => array(
                'notyf' => array(
                    'scripts' => array(
                        'jquery.js',
                        'notyf.js'
                    ),
                    'styles' => array(
                        'notyf.css'
                    ),
                    'options' => array(
                        'timeout' => 5000,
                        'position' => 'top-right'
                    )
                )
            ),
        );

        $this->assertEquals($expected, $config);
    }

    public function testEmptyDefault()
    {
        $this->setExpectedException('\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException', 'The path "flasher.default" cannot contain an empty value, but got "".');
        $this->process(array(array('default' => '')));
    }

    /**
     * Processes an array of configurations and returns a compiled version.
     *
     * @param array $configs An array of raw configurations
     *
     * @return array A normalized array
     */
    private function process($configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration(new Configuration(), $configs);
    }
}
