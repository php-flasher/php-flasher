<?php

namespace Flasher\Toastr\Laravel\ServiceProvider\Providers;

use Flasher\Toastr\Laravel\FlasherToastrServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(FlasherToastrServiceProvider $provider);

    public function registerToastrServices();

    public function mergeConfigFromToastr();
}
