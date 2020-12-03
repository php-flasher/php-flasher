<?php

namespace Flasher\Toastr\Laravel\ServiceProvider\Providers;

use Flasher\Toastr\LaravelFlasher\PrimeToastrServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(NotifyToastrServiceProvider $provider);

    public function registerNotifyToastrServices();

    public function mergeConfigFromToastr();
}
