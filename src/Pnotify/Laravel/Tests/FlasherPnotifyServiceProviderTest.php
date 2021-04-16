<?php

namespace Flasher\Pnotify\Laravel\Tests;

class FlasherPnotifyServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.pnotify'));
        $this->assertInstanceOf('Flasher\Pnotify\Prime\PnotifyFactory', $this->app->make('flasher.pnotify'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');
        $adapter = $flasher->create('pnotify');

        $this->assertInstanceOf('Flasher\Pnotify\Prime\PnotifyFactory', $adapter);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $config = $this->app->make('flasher.config');

        $expected = array(
            'scripts' => array(
                'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-pnotify@0.1.1/dist/flasher-pnotify.min.js',
            ),
            'styles'  => array(),
            'options' => array(
                'delay' => 1000,
            ),
        );

        $this->assertEquals($expected, $config->get('adapters.pnotify'));
    }
}
