<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\FlasherServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    public function boot(FlasherServiceProvider $provider);

    public function register(FlasherServiceProvider $provider);
}
