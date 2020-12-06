<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\FlasherServiceProvider;

interface ServiceProviderInterface
{
    public function shouldBeUsed();

    public function publishConfig(FlasherServiceProvider $provider);

    public function publishAssets(FlasherServiceProvider $provider);

    public function registerServices();

    public function registerBladeDirectives();
}
