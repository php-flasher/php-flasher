<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Laravel\Lumen\Application;
use Flasher\SweetAlert\Laravel\NotifySweetAlertServiceProvider;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(NotifySweetAlertServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $this->app->configure('notify_sweet_alert');

        $provider->mergeConfigFrom($source, 'notify_sweet_alert');
    }
}
