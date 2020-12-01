<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\Laravel\NotifyNotyfServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(NotifyNotyfServiceProvider $provider);

    public function registerNotifyNotyfServices();

    public function mergeConfigFromNotyf();
}
