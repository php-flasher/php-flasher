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
}
