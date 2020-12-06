<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;
use Laravel\Lumen\Application;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(FlasherPnotifyServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../Resources/config/config.php') ?: $raw;

        $this->app->configure('flasher_pnotify');

        $provider->mergeConfigFrom($source, 'flasher_pnotify');
    }
}
