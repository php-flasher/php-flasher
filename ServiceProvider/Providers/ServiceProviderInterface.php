<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(FlasherPnotifyServiceProvider $provider);

    public function registerNotifyPnotifyServices();

    public function mergeConfigFromPnotify();
}
