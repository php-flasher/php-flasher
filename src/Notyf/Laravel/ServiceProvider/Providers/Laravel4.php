<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\Laravel\FlasherNotyfServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function publishConfig(FlasherNotyfServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-laravel-notyf', 'flasher_notyf', __DIR__.'/../../../resources');
    }

    public function mergeConfigFromNotyf()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.notyf', array());

        $notyfConfig = $this->app['config']->get('flasher_notyf::config', array());

        $this->app['config']->set('flasher::config.adapters.notyf', array_merge($notyfConfig, $flasherConfig));
    }
}
