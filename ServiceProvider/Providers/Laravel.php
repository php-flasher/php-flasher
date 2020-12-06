<?php

namespace Flasher\Noty\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\Prime\Renderer\RendererManager;
use Flasher\Noty\Laravel\FlasherNotyfServiceProvider;
use Flasher\Noty\Prime\NotyFactory;
use Flasher\Noty\Prime\NotyRenderer;
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

        $provider->publishes(array($source => config_path('flasher_noty.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher_noty');
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.factory.noty', function (Container $app) {
            return new NotyFactory($app['flasher.event_dispatcher']);
        });

        $this->app->singleton('flasher.renderer.noty', function (Container $app) {
            return new NotyRenderer($app['flasher.config']);
        });

        $this->app->alias('flasher.factory.noty', 'Flasher\Noty\Prime\NotyFactory');
        $this->app->alias('flasher.renderer.noty', 'Flasher\Noty\Prime\NotyRenderer');

        $this->app->extend('flasher', function (Flasher $flasher, Container $app) {
            $flasher->addDriver($app['flasher.factory.noty']);

            return $flasher;
        });

        $this->app->extend('flasher.renderer_manager', function (RendererManager $manager, Container $app) {
            $manager->addDriver($app['flasher.renderer.noty']);

            return $manager;
        });
    }

    public function mergeConfigFromNoty()
    {
        $flasherConfig = $this->app['config']->get('flasher.adapters.noty', array());

        $notyConfig = $this->app['config']->get('flasher_noty', array());

        $this->app['config']->set('flasher.adapters.noty', array_merge($notyConfig, $flasherConfig));
    }
}
