<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Illuminate\Foundation\Application;
use Flasher\Notyf\LaravelFlasher\PrimeNotyfServiceProvider;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function publishConfig(NotifyNotyfServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-laravel-notyf', 'notify_notyf', __DIR__.'/../../../resources');
    }

    public function mergeConfigFromNotyf()
    {
        $notifyConfig = $this->app['config']->get('notify::config.adapters.notyf', array());

        $notyfConfig = $this->app['config']->get('notify_notyf::config', array());

        $this->app['config']->set('notify::config.adapters.notyf', array_merge($notyfConfig, $notifyConfig));
    }
}
