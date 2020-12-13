<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;
use Illuminate\Foundation\Application;

final class Laravel4 extends Laravel
{
    public function shouldBeUsed()
    {
        return $this->app instanceof Application && 0 === strpos(Application::VERSION, '4.');
    }

    public function publishConfig(FlasherPnotifyServiceProvider $provider)
    {
        $provider->package('php-flasher/flasher-pnotify-laravel', 'flasher_pnotify', flasher_path(__DIR__.'/../../Resources'));
    }

    public function mergeConfigFromPnotify()
    {
        $flasherConfig = $this->app['config']->get('flasher::config.adapters.pnotify', array());

        $pnotifyConfig = $this->app['config']->get('flasher_pnotify::config', array());

        $this->app['config']->set('flasher::config.adapters.pnotify', array_merge($pnotifyConfig, $flasherConfig));
    }
}
