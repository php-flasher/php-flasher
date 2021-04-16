<?php

namespace Flasher\Toastr\Laravel\Tests;

class FlasherToastrServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.toastr'));
        $this->assertInstanceOf('Flasher\Toastr\Prime\ToastrFactory', $this->app->make('flasher.toastr'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');
        $adapter = $flasher->create('toastr');

        $this->assertInstanceOf('Flasher\Toastr\Prime\ToastrFactory', $adapter);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $config = $this->app->make('flasher.config');

        $expected = array(
            'scripts' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@0.1.3/dist/flasher-toastr.min.js',
            ),
            'styles' => array(),
            'options' => array(
                'progressBar' => true,
                'timeOut' => 5000,
            ),
        );

        $this->assertEquals($expected, $config->get('adapters.toastr'));
    }
}
