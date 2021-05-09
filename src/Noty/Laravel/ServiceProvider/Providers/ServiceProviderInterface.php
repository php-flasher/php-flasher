<?php

namespace Flasher\Noty\Laravel\ServiceProvider\Providers;

use Flasher\Noty\Laravel\FlasherNotyServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    public function boot(FlasherNotyServiceProvider $provider);

    public function register(FlasherNotyServiceProvider $provider);
}
