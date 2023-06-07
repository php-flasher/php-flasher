<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel;

use Flasher\Prime\FlasherInterface;

final class ServiceProviderTest extends TestCase
{
    public function testContainerContainServices(): void
    {
        $this->assertTrue($this->app->bound('flasher'));
        $this->assertTrue($this->app->bound('flasher.noty'));
        $this->assertTrue($this->app->bound('flasher.notyf'));
        $this->assertTrue($this->app->bound('flasher.pnotify'));
        $this->assertTrue($this->app->bound('flasher.sweetalert'));
        $this->assertTrue($this->app->bound('flasher.toastr'));

        $this->assertInstanceOf(\Flasher\Prime\Flasher::class, $this->app->make('flasher'));
        $this->assertInstanceOf(\Flasher\Noty\Prime\NotyFactory::class, $this->app->make('flasher.noty'));
        $this->assertInstanceOf(\Flasher\Notyf\Prime\NotyfFactory::class, $this->app->make('flasher.notyf'));
        $this->assertInstanceOf(\Flasher\Pnotify\Prime\PnotifyFactory::class, $this->app->make('flasher.pnotify'));
        $this->assertInstanceOf(\Flasher\SweetAlert\Prime\SweetAlertFactory::class, $this->app->make('flasher.sweetalert'));
        $this->assertInstanceOf(\Flasher\Toastr\Prime\ToastrFactory::class, $this->app->make('flasher.toastr'));
    }

    public function testFlasherCanCreateServicesFromAlias(): void
    {
        /** @var FlasherInterface $flasher */
        $flasher = $this->app->make('flasher');

        $adapter = $flasher->create('noty');
        $this->assertInstanceOf(\Flasher\Noty\Prime\NotyFactory::class, $adapter);

        $adapter = $flasher->create('notyf');
        $this->assertInstanceOf(\Flasher\Notyf\Prime\NotyfFactory::class, $adapter);

        $adapter = $flasher->create('pnotify');
        $this->assertInstanceOf(\Flasher\Pnotify\Prime\PnotifyFactory::class, $adapter);

        $adapter = $flasher->create('sweetalert');
        $this->assertInstanceOf(\Flasher\SweetAlert\Prime\SweetAlertFactory::class, $adapter);

        $adapter = $flasher->create('toastr');
        $this->assertInstanceOf(\Flasher\Toastr\Prime\ToastrFactory::class, $adapter);
    }
}
