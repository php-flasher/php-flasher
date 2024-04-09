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
        $this->assertTrue($this->app->bound('flasher.sweetalert'));
        $this->assertTrue($this->app->bound('flasher.toastr'));

        $this->assertInstanceOf(\Flasher\Prime\Flasher::class, $this->app->make('flasher'));
        $this->assertInstanceOf(\Flasher\Noty\Prime\Noty::class, $this->app->make('flasher.noty'));
        $this->assertInstanceOf(\Flasher\Notyf\Prime\Notyf::class, $this->app->make('flasher.notyf'));
        $this->assertInstanceOf(\Flasher\SweetAlert\Prime\SweetAlert::class, $this->app->make('flasher.sweetalert'));
        $this->assertInstanceOf(\Flasher\Toastr\Prime\Toastr::class, $this->app->make('flasher.toastr'));
    }

    public function testFlasherCanCreateServicesFromAlias(): void
    {
        /** @var FlasherInterface $flasher */
        $flasher = $this->app->make('flasher');

        $adapter = $flasher->use('noty');
        $this->assertInstanceOf(\Flasher\Noty\Prime\Noty::class, $adapter);

        $adapter = $flasher->use('notyf');
        $this->assertInstanceOf(\Flasher\Notyf\Prime\Notyf::class, $adapter);

        $adapter = $flasher->use('sweetalert');
        $this->assertInstanceOf(\Flasher\SweetAlert\Prime\SweetAlert::class, $adapter);

        $adapter = $flasher->use('toastr');
        $this->assertInstanceOf(\Flasher\Toastr\Prime\Toastr::class, $adapter);
    }
}
