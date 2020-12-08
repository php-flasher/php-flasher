<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\Prime\Renderer\RendererManager;
use Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Flasher\SweetAlert\Prime\SweetAlertRenderer;
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
            return new SweetAlertFactory($app['flasher.event_dispatcher']);
        });

        $this->app->singleton('flasher.renderer.sweet_alert', function (Container $app) {
            return new SweetAlertRenderer($app['flasher.config']);
        });

        $this->app->alias('flasher.factory.sweet_alert', 'Flasher\SweetAlert\Prime\SweetAlertFactory');
        $this->app->alias('flasher.renderer.sweet_alert', 'Flasher\SweetAlert\Prime\SweetAlertRenderer');

        $this->app->extend('flasher', function (Flasher $manager, Container $app) {
            $manager->addFactory($app['flasher.factory.sweet_alert']);

            return $manager;
        });

        $this->app->extend('flasher.renderer_manager', function (RendererManager $manager, Container $app) {
            $manager->addDriver($app['flasher.renderer.sweet_alert']);

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
