<?php

namespace Flasher\Notyf\Symfony\Tests\DependencyInjection;

use Flasher\Notyf\Symfony\DependencyInjection\Configuration;
use Flasher\Prime\Tests\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $config = $this->process(array());

        $expected = array(
            'scripts' => array(
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@0.1.5/dist/flasher-notyf.min.js',
            ),
            'styles' => array(),
            'options' => array(
                'duration' => 5000,
                'types' => array(
                    array(
                        'type'            => 'info',
                        'className'       => 'notyf__toast--info',
                        'backgroundColor' => '#5784E5',
                        'icon'            => false,
                    ),
                    array(
                        'type'            => 'warning',
                        'className'       => 'notyf__toast--warning',
                        'backgroundColor' => '#E3A008',
                        'icon'            => false,
                    )
                ),
            ),
        );

        $this->assertSame($expected, $config);
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
