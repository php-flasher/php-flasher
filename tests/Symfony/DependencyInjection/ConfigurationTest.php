<?php

namespace Flasher\Tests\Symfony\DependencyInjection;

use Flasher\Tests\Prime\TestCase;
use Flasher\Symfony\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $config = $this->process(array());

        $expected = array(
            'default' => 'template',
            'root_script' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@0.3.0/dist/flasher.min.js',
            'root_scripts' => array(),
            'template_factory' => array(
                'default' => 'tailwindcss',
                'templates' => array(
                    'tailwindcss' => array(
                        'view' => Configuration::getTemplate('tailwindcss.html.twig'),
                        'styles' => array(
                            'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.11/base.min.css',
                            'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.11/utilities.css',
                        ),
                    ),
                    'tailwindcss_bg' => array(
                        'view' => Configuration::getTemplate('tailwindcss_bg.html.twig'),
                        'styles' => array(
                            'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.11/base.min.css',
                            'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.11/utilities.css',
                        ),
                    ),
                    'bootstrap' => array(
                        'view' => Configuration::getTemplate('bootstrap.html.twig'),
                        'styles' => array(
                            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css',
                        ),
                    ),
                ),
            ),
            'auto_create_from_session' => true,
            'types_mapping' => array(
                'success' => array(
                    'success',
                ),
                'error' => array(
                    'error',
                    'danger',
                ),
                'warning' => array(
                    'warning',
                    'alarm',
                ),
                'info' => array(
                    'info',
                    'notice',
                    'alert',
                ),
            ),
        );

        $this->assertEquals($expected, $config);
    }

    public function testEmptyDefault()
    {
        $this->setExpectedException(
            '\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            'The path "flasher.default" cannot contain an empty value, but got "".'
        );
        $this->process(array(array(
            'default' => '',
        )));
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
