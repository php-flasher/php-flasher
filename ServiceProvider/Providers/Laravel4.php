<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function publishConfig(FlasherSweetAlertServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-laravel-sweet_alert', 'flasher_sweet_alert', __DIR__.'/../../../resources');
    }

    public function mergeConfigFromSweetAlert()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.sweet_alert', array());

        $sweetAlertConfig = $this->app['config']->get('flasher_sweet_alert::config', array());

        $this->app['config']->set('flasher::config.adapters.sweet_alert', array_merge($sweetAlertConfig, $flasherConfig));
    }
}
