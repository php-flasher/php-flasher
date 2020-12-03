<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\LaravelFlasher\PrimeNotyfServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(NotifyNotyfServiceProvider $provider);

    public function registerNotifyNotyfServices();

    public function mergeConfigFromNotyf();
}
