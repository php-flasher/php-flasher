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
                'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js',
                '/bundles/flashernoty/flasher-noty.js',
            ),
            'styles'  => array(
                'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css',
            ),
            'options' => array(
                'layout'              => 'topRight',
                'theme'               => 'mint',
                'timeout'             => false,
                'progressBar'         => true,
                'animation.open'      => 'noty_effects_open',
                'animation.close'     => 'noty_effects_close',
                'sounds.sources'      => array(),
                'closeWith'           => array('click'),
                'sounds.volume'       => 1,
                'sounds.conditions'   => array(),
                'docTitle.conditions' => array(),
                'modal'               => false,
                'id'                  => false,
                'force'               => false,
                'queue'               => 'global',
                'killer'              => false,
                'container'           => false,
                'buttons'             => array(),
                'visibilityControl'   => false,
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
