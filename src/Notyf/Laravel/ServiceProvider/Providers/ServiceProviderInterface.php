<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\Laravel\FlasherNotyfServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(FlasherNotyfServiceProvider $provider);

    public function registerServices();

    public function mergeConfigFromNotyf();
}
