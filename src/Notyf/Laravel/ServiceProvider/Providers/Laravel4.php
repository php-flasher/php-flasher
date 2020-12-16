<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\Laravel\FlasherNotyfServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    /**
     * @inheritDoc
     */
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    /**
     * @inheritDoc
     */
    public function boot(FlasherNotyfServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-notyf-laravel', 'flasher_notyf', flasher_path(__DIR__.'/../../Resources'));

        $this->appendToFlasherConfig();
    }

    /**
     * @inheritDoc
     */
    public function register(FlasherNotyfServiceProvider $provider)
    {
        $this->registerServices();
    }

    protected function appendToFlasherConfig()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.notyf', array());

        $notyfConfig = $this->app['config']->get('flasher_notyf::config', array());

        $this->app['config']->set('flasher::config.adapters.notyf', array_merge($notyfConfig, $flasherConfig));
    }
}
