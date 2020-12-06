<?php

namespace Flasher\Noty\Laravel\ServiceProvider\Providers;

use Flasher\Noty\Laravel\FlasherNotyfServiceProvider;
use Laravel\Lumen\Application;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(FlasherNotyfServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../Resources/config/config.php') ?: $raw;

        $this->app->configure('flasher_noty');

        $provider->mergeConfigFrom($source, 'flasher_noty');
    }
}
