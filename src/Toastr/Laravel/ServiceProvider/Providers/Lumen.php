<?php

namespace Flasher\Toastr\Laravel\ServiceProvider\Providers;

use Laravel\Lumen\Application;
use Flasher\Toastr\LaravelFlasher\PrimeToastrServiceProvider;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(NotifyToastrServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $this->app->configure('notify_toastr');

        $provider->mergeConfigFrom($source, 'notify_toastr');
    }
}
