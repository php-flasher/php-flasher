<?php

namespace Flasher\Toastr\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\Toastr\Laravel\FlasherToastrServiceProvider;
use Flasher\Toastr\Prime\ToastrFactory;
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

    public function publishConfig(FlasherToastrServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../Resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('flasher_toastr.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher_toastr');
    }

    public function registerToastrServices()
    {
        $this->app->singleton('flasher.toastr', function (Container $app) {
            return new ToastrFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.toastr', 'Flasher\Toastr\Prime\ToastrFactory');

        $this->app->extend('flasher', function (Flasher $flasher, Container $app) {
            $flasher->addFactory('toastr', $app['flasher.toastr']);

            return $flasher;
        });
    }

    public function mergeConfigFromToastr()
    {
        $flasherConfig = $this->app['config']->get('flasher.adapters.toastr', array());

        $toastrConfig = $this->app['config']->get('flasher_toastr', array());

        $this->app['config']->set('flasher.adapters.toastr', array_merge($toastrConfig, $flasherConfig));
    }
}
