<?php

namespace Flasher\Toastr\Laravel\ServiceProvider\Providers;

use Flasher\Toastr\Laravel\FlasherToastrServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    /**
     * @param FlasherToastrServiceProvider $provider
     */
    public function boot(FlasherToastrServiceProvider $provider);

    /**
     * @param FlasherToastrServiceProvider $provider
     */
    public function register(FlasherToastrServiceProvider $provider);
}
