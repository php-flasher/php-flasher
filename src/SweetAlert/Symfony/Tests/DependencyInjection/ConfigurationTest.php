<?php

namespace Flasher\SweetAlert\Symfony\Tests\DependencyInjection;

use Flasher\Prime\Tests\TestCase;
use Flasher\SweetAlert\Symfony\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $config = $this->process(array());

        $expected = array(
            'scripts' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweet-alert@0.1.3/dist/flasher-sweet-alert.min.js',
            ),
            'styles' => array(),
            'options' => array(
                'timer' => 5000,
                'timerProgressBar' => true,
            ),
        );

        $this->assertEquals($expected, $config);
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
