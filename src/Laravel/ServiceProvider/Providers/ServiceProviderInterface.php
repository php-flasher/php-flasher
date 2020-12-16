<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\FlasherServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    /**
     * @param FlasherServiceProvider $provider
     */
    public function boot(FlasherServiceProvider $provider);

    /**
     * @param FlasherServiceProvider $provider
     */
    public function register(FlasherServiceProvider $provider);
}
