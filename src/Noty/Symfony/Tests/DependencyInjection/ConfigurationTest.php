<?php

namespace Flasher\Noty\Symfony\Tests\DependencyInjection;

use Flasher\Noty\Symfony\DependencyInjection\Configuration;
use Flasher\Prime\Tests\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $config = $this->process(array());

        $expected = array(
            'scripts' => array(
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@0.1.3/dist/flasher-noty.min.js',
            ),
            'styles' => array(),
            'options' => array(
                'timeout' => 5000,
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
