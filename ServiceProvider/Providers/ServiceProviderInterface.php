<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\Laravel\FlasherNotyfServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    /**
     * @param FlasherNotyfServiceProvider $provider
     */
    public function boot(FlasherNotyfServiceProvider $provider);

    /**
     * @param FlasherNotyfServiceProvider $provider
     */
    public function register(FlasherNotyfServiceProvider $provider);
}
