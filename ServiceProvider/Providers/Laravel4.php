<?php

namespace Flasher\Toastr\Laravel\ServiceProvider\Providers;

use Flasher\Toastr\Laravel\FlasherToastrServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function publishConfig(FlasherToastrServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-laravel-toastr', 'flasher_toastr', __DIR__.'/../../../resources');
    }

    public function mergeConfigFromToastr()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.toastr', array());

        $toastrConfig = $this->app['config']->get('flasher_toastr::config', array());

        $this->app['config']->set('flasher::config.adapters.toastr', array_merge($toastrConfig, $flasherConfig));
    }
}
