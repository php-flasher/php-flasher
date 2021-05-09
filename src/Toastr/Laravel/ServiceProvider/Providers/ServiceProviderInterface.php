<?php

namespace Flasher\Toastr\Laravel\ServiceProvider\Providers;

use Flasher\Toastr\Laravel\FlasherToastrServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    public function boot(FlasherToastrServiceProvider $provider);

    public function register(FlasherToastrServiceProvider $provider);
}
