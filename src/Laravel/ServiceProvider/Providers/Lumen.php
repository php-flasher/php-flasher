<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\FlasherServiceProvider;
use Laravel\Lumen\Application;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(FlasherServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../Resources/config/config.php') ?: $raw;

        $this->app->configure('flasher');

        $provider->mergeConfigFrom($source, 'flasher');
    }

    public function registerServices()
    {
        $this->app->register('\Illuminate\Session\SessionServiceProvider');
        $this->app->configure('session');

        parent::registerServices();
    }
}
