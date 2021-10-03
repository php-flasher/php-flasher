<?php

namespace Flasher\Tests\SweetAlert\Laravel;

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
}
