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

    public function boot(FlasherSweetAlertServiceProvider $provider)
    {
        $provider->package(
            'php-flasher/flasher-sweet_alert-laravel',
            'flasher_sweet_alert',
            flasher_path(__DIR__ . '/../../Resources')
        );
        $this->appendToFlasherConfig();
    }

    public function register(FlasherSweetAlertServiceProvider $provider)
    {
        $this->registerServices();
    }

    public function appendToFlasherConfig()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.sweet_alert', array());

        $sweetAlertConfig = $this->app['config']->get('flasher_sweet_alert::config', array());

        $this->app['config']->set(
            'flasher::config.adapters.sweet_alert',
            array_merge($sweetAlertConfig, $flasherConfig)
        );
    }
}
