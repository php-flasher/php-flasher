<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\LaravelFlasher\PrimeNotyfServiceProvider;
use Flasher\Notyf\Prime\Factory\NotyfProducer;
use Flasher\Notyf\Prime\Renderer\NotyfRenderer;
use Flasher\Prime\Flasher;
use Flasher\Prime\Renderer\RendererManager;
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

    public function publishConfig(NotifyNotyfServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('notify_notyf.php')), 'config');

        $provider->mergeConfigFrom($source, 'notify_notyf');
    }

    public function registerNotifyNotyfServices()
    {
        $this->app->singleton('flasher.factory.notyf', function (Container $app) {
            return new NotyfProducer($app['flasher.storage'], $app['flasher.middleware']);
        });

        $this->app->singleton('flasher.renderer.notyf', function (Container $app) {
            return new NotyfRenderer($app['flasher.config']);
        });

        $this->app->alias('flasher.factory.notyf', 'Flasher\Notyf\Prime\Factory\NotyfProducer');
        $this->app->alias('flasher.renderer.notyf', 'Flasher\Notyf\Prime\Renderer\NotyfRenderer');

        $this->app->extend('flasher.factory', function (Flasher $manager, Container $app) {
            $manager->addDriver('notyf', $app['flasher.factory.notyf']);

            return $manager;
        });

        $this->app->extend('flasher.renderer', function (RendererManager $manager, Container $app) {
            $manager->addDriver('notyf', $app['flasher.renderer.notyf']);

            return $manager;
        });
    }

    public function mergeConfigFromNotyf()
    {
        $notifyConfig = $this->app['config']->get('flasher.adapters.notyf', array());

        $notyfConfig = $this->app['config']->get('notify_notyf', array());

        $this->app['config']->set('flasher.adapters.notyf', array_merge($notyfConfig, $notifyConfig));
    }
}
