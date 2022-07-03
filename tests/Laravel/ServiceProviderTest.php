<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Laravel;

use Flasher\Prime\FlasherInterface;

final class ServiceProviderTest extends TestCase
{
    /**
     * @return void
     */
    public function testContainerContainServices()
    {
        $this->assertTrue($this->app->bound('flasher'));
        $this->assertTrue($this->app->bound('flasher.noty'));
        $this->assertTrue($this->app->bound('flasher.notyf'));
        $this->assertTrue($this->app->bound('flasher.pnotify'));
        $this->assertTrue($this->app->bound('flasher.sweetalert'));
        $this->assertTrue($this->app->bound('flasher.toastr'));

        $this->assertInstanceOf('Flasher\Noty\Prime\NotyFactory', $this->app->make('flasher.noty'));
        $this->assertInstanceOf('Flasher\Notyf\Prime\NotyfFactory', $this->app->make('flasher.notyf'));
        $this->assertInstanceOf('Flasher\Pnotify\Prime\PnotifyFactory', $this->app->make('flasher.pnotify'));
        $this->assertInstanceOf('Flasher\SweetAlert\Prime\SweetAlertFactory', $this->app->make('flasher.sweetalert'));
        $this->assertInstanceOf('Flasher\Toastr\Prime\ToastrFactory', $this->app->make('flasher.toastr'));
    }

    /**
     * @return void
     */
    public function testFlasherCanCreateServicesFromAlias()
    {
        /** @var FlasherInterface $flasher */
        $flasher = $this->app->make('flasher');

        $adapter = $flasher->create('noty');
        $this->assertInstanceOf('Flasher\Noty\Prime\NotyFactory', $adapter);

        $adapter = $flasher->create('notyf');
        $this->assertInstanceOf('Flasher\Notyf\Prime\NotyfFactory', $adapter);

        $adapter = $flasher->create('pnotify');
        $this->assertInstanceOf('Flasher\Pnotify\Prime\PnotifyFactory', $adapter);

        $adapter = $flasher->create('sweetalert');
        $this->assertInstanceOf('Flasher\SweetAlert\Prime\SweetAlertFactory', $adapter);

        $adapter = $flasher->create('toastr');
        $this->assertInstanceOf('Flasher\Toastr\Prime\ToastrFactory', $adapter);
    }
}
