<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\SweetAlert\Laravel\NotifySweetAlertServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(NotifySweetAlertServiceProvider $provider);

    public function registerNotifySweetAlertServices();

    public function mergeConfigFromSweetAlert();
}
