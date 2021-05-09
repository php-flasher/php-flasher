<?php

namespace Flasher\Pnotify\Symfony\Tests\DependencyInjection;

use Flasher\Pnotify\Symfony\DependencyInjection\Configuration;
use Flasher\Prime\Tests\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $config = $this->process(array());

        $expected = array(
            'scripts' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-pnotify@0.1.1/dist/flasher-pnotify.min.js',
            ),
            'styles' => array(),
            'options' => array(
                'delay' => 1000,
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
