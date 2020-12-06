<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\Prime\Renderer\RendererManager;
use Flasher\SweetAlert\LaravelFlasher\PrimeSweetAlertServiceProvider;
use Flasher\SweetAlert\Prime\Factory\SweetAlertProducer;
use Flasher\SweetAlert\Prime\Renderer\SweetAlertRenderer;
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

    public function publishConfig(NotifySweetAlertServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('notify_sweet_alert.php')), 'config');

        $provider->mergeConfigFrom($source, 'notify_sweet_alert');
    }

    public function registerNotifySweetAlertServices()
    {
        $this->app->singleton('flasher.factory.sweet_alert', function (Container $app) {
            return new SweetAlertProducer($app['flasher.storage'], $app['flasher.middleware']);
        });

        $this->app->singleton('flasher.renderer.sweet_alert', function (Container $app) {
            return new SweetAlertRenderer($app['flasher.config']);
        });

        $this->app->alias('flasher.factory.sweet_alert', 'Flasher\SweetAlert\Prime\Factory\SweetAlertProducer');
        $this->app->alias('flasher.renderer.sweet_alert', 'Flasher\SweetAlert\Prime\Renderer\SweetAlertRenderer');

        $this->app->extend('flasher.factory', function (Flasher $manager, Container $app) {
            $manager->addDriver('sweet_alert', $app['flasher.factory.sweet_alert']);

            return $manager;
        });

        $this->app->extend('flasher.renderer', function (RendererManager $manager, Container $app) {
            $manager->addDriver('sweet_alert', $app['flasher.renderer.sweet_alert']);

            return $manager;
        });
    }

    public function mergeConfigFromSweetAlert()
    {
        $notifyConfig = $this->app['config']->get('flasher.adapters.sweet_alert', array());

        $sweetAlertConfig = $this->app['config']->get('notify_sweet_alert', array());

        $this->app['config']->set('flasher.adapters.sweet_alert', array_merge($sweetAlertConfig, $notifyConfig));
    }
}
