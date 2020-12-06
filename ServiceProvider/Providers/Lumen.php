<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider;
use Laravel\Lumen\Application;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(FlasherSweetAlertServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $this->app->configure('flasher_sweet_alert');

        $provider->mergeConfigFrom($source, 'flasher_sweet_alert');
    }
}
