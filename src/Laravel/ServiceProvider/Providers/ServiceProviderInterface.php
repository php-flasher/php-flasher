<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\NotifyServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(NotifyServiceProvider $provider);

    public function publishAssets(NotifyServiceProvider $provider);

    public function registerNotifyServices();

    public function registerBladeDirectives();
}
