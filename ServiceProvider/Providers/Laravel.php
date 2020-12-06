<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\PFlasher\Prime\PnotifyRenderer;
use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;
use Flasher\Pnotify\Prime\PnotifyFactory;
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

    public function publishConfig(FlasherPnotifyServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../Resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('flasher_pnotify.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher_pnotify');
    }

    public function registerNotifyPnotifyServices()
    {
        $this->app->singleton('flasher.factory.pnotify', function (Container $app) {
            return new PnotifyFactory($app['flasher.event_dispatcher']);
        });

        $this->app->singleton('flasher.renderer.pnotify', function (Container $app) {
            return new PnotifyRenderer($app['flasher.config']);
        });

        $this->app->alias('flasher.factory.pnotify', 'Flasher\PFlasher\Prime\TestsProducer\PnotifyProducer');
        $this->app->alias('flasher.renderer.pnotify', 'Flasher\PFlasher\Prime\Renderer\PnotifyRenderer');

        $this->app->extend('flasher', function (Flasher $manager, Container $app) {
            $manager->addDriver($app['flasher.factory.pnotify']);

            return $manager;
        });

        $this->app->extend('flasher.renderer', function (RendererManager $manager, Container $app) {
            $manager->addDriver($app['flasher.renderer.pnotify']);

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
