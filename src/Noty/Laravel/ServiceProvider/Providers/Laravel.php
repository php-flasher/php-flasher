<?php

namespace Flasher\Noty\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\Noty\Laravel\FlasherNotyServiceProvider;
use Flasher\Noty\Prime\NotyFactory;
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

    public function publishConfig(FlasherNotyServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../Resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('flasher_noty.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher_noty');
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.noty', function (Container $app) {
            return new NotyFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.noty', 'Flasher\Noty\Prime\NotyFactory');

        $this->app->extend('flasher', function (Flasher $flasher, Container $app) {
            $flasher->addFactory('toastr', $app['flasher.noty']);

            return $flasher;
        });
    }

    public function mergeConfigFromNoty()
    {
        $flasherConfig = $this->app['config']->get('flasher.adapters.noty', array());

        $notyConfig = $this->app['config']->get('flasher_noty', array());

        $this->app['config']->set('flasher.adapters.noty', array_merge($notyConfig, $flasherConfig));
    }
}
