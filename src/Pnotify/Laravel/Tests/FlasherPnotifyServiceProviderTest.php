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
}
