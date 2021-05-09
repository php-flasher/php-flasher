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
            'default' => 'template',
            'root_scripts' => array(
                'https://cdn.jsdelivr.net/npm/@flasher/flasher@0.1.3/dist/flasher.min.js',
            ),
            'template_factory' => array(
                'default' => 'tailwindcss',
                'templates' => array(
                    'tailwindcss' => array(
                        'view' => '@FlasherSymfony/tailwindcss.html.twig',
                        'styles' => array(
                            'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.1/base.min.css',
                            'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.1/utilities.css',
                        ),
                    ),
                    'tailwindcss_bg' => array(
                        'view' => '@FlasherSymfony/tailwindcss_bg.html.twig',
                        'styles' => array(
                            'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.1/base.min.css',
                            'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.1/utilities.css',
                        ),
                    ),
                    'bootstrap' => array(
                        'view' => '@FlasherSymfony/bootstrap.html.twig',
                        'styles' => array(
                            'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css',
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

        $this->assertSame($expected, $config);
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
