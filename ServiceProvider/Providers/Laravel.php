<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;
use Flasher\Pnotify\Prime\PnotifyFactory;
use Flasher\Prime\Flasher;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;

class Laravel implements ServiceProviderInterface
{
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function publishConfig(FlasherPnotifyServiceProvider $provider)
    {
        $source = realpath($raw = flasher_path(__DIR__.'/../../Resources/config/config.php')) ?: $raw;

        $provider->publishes(array($source => config_path('flasher_pnotify.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher_pnotify');
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.pnotify', function (Container $app) {
            return new PnotifyFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.pnotify', 'Flasher\Pnotify\Prime\PnotifyFactory');

        $this->app->extend('flasher', function (Flasher $manager, Container $app) {
            $manager->addFactory('pnotify', $app['flasher.pnotify']);

            return $manager;
        });
    }

    public function mergeConfigFromPnotify()
    {
        $flasherConfig = $this->app['config']->get('flasher.adapters.pnotify', array());

        $pnotifyConfig = $this->app['config']->get('flasher_pnotify', array());

        $this->app['config']->set('flasher.adapters.pnotify', array_merge($pnotifyConfig, $flasherConfig));
    }
}
