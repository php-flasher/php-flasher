<?php

namespace Flasher\Noty\Laravel\ServiceProvider\Providers;

use Flasher\Noty\Laravel\FlasherNotyfServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function publishConfig(FlasherNotyfServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-noty-laravel', 'flasher_noty', __DIR__.'/../../Resources');
    }

    public function mergeConfigFromNoty()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.noty', array());

        $notyConfig = $this->app['config']->get('flasher_noty::config', array());

        $this->app['config']->set('flasher::config.adapters.noty', array_merge($notyConfig, $flasherConfig));
    }
}
