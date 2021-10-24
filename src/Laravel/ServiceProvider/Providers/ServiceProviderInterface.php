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
     * @return void
     */
    public function boot(FlasherServiceProvider $provider);

    /**
     * @return void
     */
    public function register(FlasherServiceProvider $provider);
}
