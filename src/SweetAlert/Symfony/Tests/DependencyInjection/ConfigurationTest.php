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
                'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.2/sweetalert2.min.js',
                'https://cdnjs.cloudflare.com/ajax/libs/promise-polyfill/8.2.0/polyfill.min.js',
                '/bundles/flashersweetalert/flasher-sweet-alert.js',
            ),
            'styles'  => array(
                'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.2/sweetalert2.min.css',
            ),
            'options' => array(
                'timer'             => 5000,
                'padding'           => '1.25rem',
                'showConfirmButton' => false,
                'showCloseButton'   => false,
                'toast'             => true,
                'position'          => 'top-end',
                'timerProgressBar'  => true,
                'animation'         => true,
                'showClass'         => array(
                    'popup' => 'animate__animated animate__fadeInDown',
                ),
                'hideClass'         => array(
                    'popup' => 'animate__animated animate__fadeOutUp',
                ),
                'backdrop'          => true,
                'grow'              => true,
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
