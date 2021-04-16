<?php

namespace Flasher\SweetAlert\Laravel\Tests;

class FlasherSweetAlertServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.sweet_alert'));
        $this->assertInstanceOf('Flasher\SweetAlert\Prime\SweetAlertFactory', $this->app->make('flasher.sweet_alert'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');
        $adapter = $flasher->create('sweet_alert');

        $this->assertInstanceOf('Flasher\SweetAlert\Prime\SweetAlertFactory', $adapter);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $config = $this->app->make('flasher.config');

        $expected = array(
            'scripts' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweet-alert@0.1.3/dist/flasher-sweet-alert.min.js',
            ),
            'styles'  => array(),
            'options' => array(
                'timer' => 50000,
                'timerProgressBar' => true,
            ),
        );

        $this->assertEquals($expected, $config->get('adapters.sweet_alert'));
    }
}
