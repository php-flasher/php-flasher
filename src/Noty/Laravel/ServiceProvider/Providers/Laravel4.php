<?php

namespace Flasher\Noty\Laravel\ServiceProvider\Providers;

use Flasher\Noty\Laravel\FlasherNotyServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function boot(FlasherNotyServiceProvider $provider)
    {
        $provider->package(
            'php-flasher/flasher-noty-laravel',
            'flasher_noty',
            flasher_path(__DIR__ . '/../../Resources')
        );
        $this->appendToFlasherConfig();
    }

    public function register(FlasherNotyServiceProvider $provider)
    {
        $this->registerServices();
    }

    protected function appendToFlasherConfig()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.noty', array());

        $notyConfig = $this->app['config']->get('flasher_noty::config', array());

        $this->app['config']->set('flasher::config.adapters.noty', array_merge($notyConfig, $flasherConfig));
    }
}
