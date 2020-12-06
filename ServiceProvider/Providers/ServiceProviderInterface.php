<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(FlasherSweetAlertServiceProvider $provider);

    public function registerServices();

    public function mergeConfigFromSweetAlert();
}
