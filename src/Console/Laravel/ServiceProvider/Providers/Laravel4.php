<?php

namespace Flasher\Console\Laravel\ServiceProvider\Providers;

use Flasher\Console\Laravel\FlasherConsoleServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function boot(FlasherConsoleServiceProvider $provider)
    {
        $provider->package(
            'php-flasher/flasher-console-laravel',
            'flasher_console',
            flasher_path(__DIR__ . '/../../Resources')
        );
    }

    public function register(FlasherConsoleServiceProvider $provider)
    {
        $this->registerServices();
    }
}
