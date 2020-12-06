<?php

namespace Flasher\Toastr\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\Prime\Renderer\RendererManager;
use Flasher\Toastr\LaravelFlasher\PrimeToastrServiceProvider;
use Flasher\Toastr\Prime\Factory\ToastrProducer;
use Flasher\Toastr\Prime\Renderer\ToastrRenderer;
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

    public function publishConfig(NotifyToastrServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('notify_toastr.php')), 'config');

        $provider->mergeConfigFrom($source, 'notify_toastr');
    }

    public function registerNotifyToastrServices()
    {
        $this->app->singleton('flasher.factory.toastr', function (Container $app) {
            return new ToastrProducer($app['flasher.storage'], $app['flasher.middleware']);
        });

        $this->app->singleton('flasher.renderer.toastr', function (Container $app) {
            return new ToastrRenderer($app['flasher.config']);
        });

        $this->app->alias('flasher.factory.toastr', 'Flasher\Toastr\Prime\Factory\ToastrProducer');
        $this->app->alias('flasher.renderer.toastr', 'Flasher\Toastr\Prime\Renderer\ToastrRenderer');

        $this->app->extend('flasher.factory', function (Flasher $manager, Container $app) {
            $manager->addDriver('toastr', $app['flasher.factory.toastr']);

            return $manager;
        });

        $this->app->extend('flasher.renderer', function (RendererManager $manager, Container $app) {
            $manager->addDriver('toastr', $app['flasher.renderer.toastr']);

            return $manager;
        });
    }

    public function mergeConfigFromToastr()
    {
        $notifyConfig = $this->app['config']->get('flasher.adapters.toastr', array());

        $toastrConfig = $this->app['config']->get('notify_toastr', array());

        $this->app['config']->set('flasher.adapters.toastr', array_merge($toastrConfig, $notifyConfig));
    }
}
