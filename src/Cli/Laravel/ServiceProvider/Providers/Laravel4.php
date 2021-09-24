<?php

namespace Flasher\Cli\Laravel\ServiceProvider\Providers;

use Flasher\Cli\Laravel\FlasherCliServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function boot(FlasherCliServiceProvider $provider)
    {
        $provider->package(
            'php-flasher/flasher-cli-laravel',
            'flasher_console',
            flasher_path(__DIR__ . '/../../Resources')
        );
    }

    public function register(FlasherCliServiceProvider $provider)
    {
        $this->registerServices();
    }
}
