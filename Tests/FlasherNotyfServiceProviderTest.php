<?php

namespace Flasher\Notyf\Laravel\Tests;

class FlasherNotyfServiceProviderTest extends TestCase
{
    public function testContainerContainNotifyServices()
    {
        $this->assertTrue($this->app->bound('flasher.notyf'));
        $this->assertInstanceOf('Flasher\Notyf\Prime\NotyfFactory', $this->app->make('flasher.notyf'));
    }

    public function testNotifyFactoryIsAddedToExtensionsArray()
    {
        $flasher = $this->app->make('flasher');
        $adapter = $flasher->create('notyf');

        $this->assertInstanceOf('Flasher\Notyf\Prime\NotyfFactory', $adapter);
    }

    public function testConfigNotyInjectedInGlobalNotifyConfig()
    {
        $config = $this->app->make('flasher.config');

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

        $this->assertEquals($expected, $config->get('adapters.notyf'));
    }
}
