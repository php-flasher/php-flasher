<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\Laravel\FlasherNotyfServiceProvider;
use Laravel\Lumen\Application;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(FlasherNotyfServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $this->app->configure('flasher_notyf');

        $provider->mergeConfigFrom($source, 'flasher_notyf');
    }
}
