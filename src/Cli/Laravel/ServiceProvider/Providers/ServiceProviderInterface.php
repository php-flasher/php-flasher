<?php

namespace Flasher\Cli\Laravel\ServiceProvider\Providers;

use Flasher\Cli\Laravel\FlasherCliServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    public function boot(FlasherCliServiceProvider $provider);

    public function register(FlasherCliServiceProvider $provider);
}
