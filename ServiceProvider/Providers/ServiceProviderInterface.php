<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Pnotify\Laravel\NotifyPnotifyServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(NotifyPnotifyServiceProvider $provider);

    public function registerNotifyPnotifyServices();

    public function mergeConfigFromPnotify();
}
