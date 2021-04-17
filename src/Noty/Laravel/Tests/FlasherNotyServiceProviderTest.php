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
}
