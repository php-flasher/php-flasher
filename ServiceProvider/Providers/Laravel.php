<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\Prime\Renderer\RendererManager;
use Flasher\SweetAlert\LaravelFlasher\PrimeSweetAlertServiceProvider;
use Flasher\SweetAlert\Prime\Producer\SweetAlertProducer;
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
        $this->app->singleton('notify.producer.sweet_alert', function (Container $app) {
            return new SweetAlertProducer($app['notify.storage'], $app['notify.middleware']);
        });

        $this->app->singleton('notify.renderer.sweet_alert', function (Container $app) {
            return new SweetAlertRenderer($app['notify.config']);
        });

        $this->app->alias('notify.producer.sweet_alert', 'Flasher\SweetAlert\Prime\Producer\SweetAlertProducer');
        $this->app->alias('notify.renderer.sweet_alert', 'Flasher\SweetAlert\Prime\Renderer\SweetAlertRenderer');

        $this->app->extend('notify.producer', function (Flasher $manager, Container $app) {
            $manager->addDriver('sweet_alert', $app['notify.producer.sweet_alert']);

            return $manager;
        });

        $this->app->extend('notify.renderer', function (RendererManager $manager, Container $app) {
            $manager->addDriver('sweet_alert', $app['notify.renderer.sweet_alert']);

            return $manager;
        });
    }

    public function mergeConfigFromSweetAlert()
    {
        $notifyConfig = $this->app['config']->get('notify.adapters.sweet_alert', array());

        $sweetAlertConfig = $this->app['config']->get('notify_sweet_alert', array());

        $this->app['config']->set('notify.adapters.sweet_alert', array_merge($sweetAlertConfig, $notifyConfig));
    }
}
