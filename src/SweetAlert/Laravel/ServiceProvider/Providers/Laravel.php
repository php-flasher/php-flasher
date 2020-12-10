<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
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

    public function publishConfig(FlasherSweetAlertServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../Resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('flasher_sweet_alert.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher_sweet_alert');
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.factory.sweet_alert', function (Container $app) {
            return new SweetAlertFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.sweet_alert', 'Flasher\SweetAlert\Prime\SweetAlertFactory');

        $this->app->extend('flasher', function (Flasher $manager, Container $app) {
            $manager->addFactory('sweet_alert', $app['flasher.factory.sweet_alert']);

            return $manager;
        });
    }

    public function mergeConfigFromSweetAlert()
    {
        $notifyConfig = $this->app['config']->get('flasher.adapters.sweet_alert', array());

        $sweetAlertConfig = $this->app['config']->get('flasher_sweet_alert', array());

        $this->app['config']->set('flasher.adapters.sweet_alert', array_merge($sweetAlertConfig, $notifyConfig));
    }
}
