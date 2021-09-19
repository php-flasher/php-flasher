<?php

namespace Flasher\Console\Laravel\ServiceProvider\Providers;

use Flasher\Console\Laravel\FlasherConsoleServiceProvider;

interface ServiceProviderInterface
{
    /**
     * @return bool
     */
    public function shouldBeUsed();

    public function boot(FlasherConsoleServiceProvider $provider);

    public function register(FlasherConsoleServiceProvider $provider);
}
