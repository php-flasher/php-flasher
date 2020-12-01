<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Laravel\Lumen\Application;
use Flasher\Pnotify\Laravel\NotifyPnotifyServiceProvider;

final class Lumen extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(NotifyPnotifyServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $this->app->configure('notify_pnotify');

        $provider->mergeConfigFrom($source, 'notify_pnotify');
    }
}
