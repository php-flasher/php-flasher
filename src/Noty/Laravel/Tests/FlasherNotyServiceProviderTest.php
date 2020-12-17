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
                'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js',
                '/vendor/flasher/flasher-noty.js',
            ),
            'styles'  => array(
                'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css',
            ),
            'options' => array(
                'layout'              => 'topRight',
                'theme'               => 'mint',
                'timeout'             => 5000,
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

        $this->assertEquals($expected, $config->get('adapters.noty'));
    }
}
