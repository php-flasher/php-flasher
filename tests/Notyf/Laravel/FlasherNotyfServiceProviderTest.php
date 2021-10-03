<?php

namespace Flasher\Tests\Notyf\Laravel;

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
}
