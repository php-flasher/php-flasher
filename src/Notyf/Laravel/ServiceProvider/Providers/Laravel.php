<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\Laravel\FlasherNotyfServiceProvider;
use Flasher\Notyf\Prime\NotyfFactory;
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

    public function publishConfig(FlasherNotyfServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../Resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('flasher_notyf.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher_notyf');
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.factory.notyf', function (Container $app) {
            return new NotyfFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.notyf', 'Flasher\Notyf\Prime\NotyfFactory');

        $this->app->extend('flasher', function (Flasher $manager, Container $app) {
            $manager->addFactory('notyf', $app['flasher.notyf']);

            return $manager;
        });
    }

    public function mergeConfigFromNotyf()
    {
        $flasherConfig = $this->app['config']->get('flasher.adapters.notyf', array());

        $notyfConfig = $this->app['config']->get('flasher_notyf', array());

        $this->app['config']->set('flasher.adapters.notyf', array_merge($notyfConfig, $flasherConfig));
    }
}
