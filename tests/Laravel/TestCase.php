<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @return array<class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            \Flasher\Laravel\FlasherServiceProvider::class,
            \Flasher\Noty\Laravel\FlasherNotyServiceProvider::class,
            \Flasher\Notyf\Laravel\FlasherNotyfServiceProvider::class,
            \Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider::class,
            \Flasher\Toastr\Laravel\FlasherToastrServiceProvider::class,
        ];
    }

    /**
     * Override application aliases.
     *
     * @return array<string, class-string<Facade>>
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Flasher' => \Flasher\Laravel\Facade\Flasher::class,
            'Noty' => \Flasher\Noty\Laravel\Facade\Noty::class,
            'Notyf' => \Flasher\Notyf\Laravel\Facade\Notyf::class,
            'SweetAlert' => \Flasher\SweetAlert\Laravel\Facade\SweetAlert::class,
            'Toastr' => \Flasher\Toastr\Laravel\Facade\Toastr::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        tap($app['config'], function (Repository $config) {
            $config->set('session.driver', 'array');
        });
    }
}
