<?php

namespace Flasher\Noty\Laravel\Tests;

class FlasherNotyServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.noty'));
        $this->assertInstanceOf('Flasher\Noty\Prime\NotyFactory', $this->app->make('flasher.noty'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');
        $adapter = $flasher->create('noty');

        $this->assertInstanceOf('Flasher\Noty\Prime\NotyFactory', $adapter);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $config = $this->app->make('flasher.config');

        $expected = array(
            'scripts' => array(
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@0.1.3/dist/flasher-noty.min.js',
            ),
            'styles'  => array(),
            'options' => array(
                'timeout' => 5000,
            ),
        );

        $this->assertEquals($expected, $config->get('adapters.noty'));
    }
}
