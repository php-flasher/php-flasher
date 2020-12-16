<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;
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
    public function boot(FlasherPnotifyServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-pnotify-laravel', 'flasher_pnotify', flasher_path(__DIR__.'/../../Resources'));

        $this->appendToFlasherConfig();
    }

    /**
     * @inheritDoc
     */
    public function register(FlasherPnotifyServiceProvider $provider)
    {
        $this->registerServices();
    }

    protected function appendToFlasherConfig()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.pnotify', array());

        $pnotifyConfig = $this->app['config']->get('flasher_pnotify::config', array());

        $this->app['config']->set('flasher::config.adapters.pnotify', array_merge($pnotifyConfig, $flasherConfig));
    }
}
