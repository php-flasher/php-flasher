<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Laravel\Lumen\Application;
use Flasher\LaravelFlasher\PrimeServiceProvider;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(NotifyServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $this->app->configure('notify');

        $provider->mergeConfigFrom($source, 'notify');
    }

    public function registerNotifyServices()
    {
        $this->app->register('\Illuminate\Session\SessionServiceProvider');
        $this->app->configure('session');

        parent::registerNotifyServices();
    }
}
