<?php

namespace Flasher\Notyf\Laravel\ServiceProvider\Providers;

use Flasher\Notyf\Laravel\FlasherNotyfServiceProvider;
use Flasher\Notyf\Prime\NotyfFactory;
use Flasher\Notyf\Prime\NotyfRenderer;
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

    public function publishConfig(FlasherNotyfServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('flasher_notyf.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher_notyf');
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.factory.notyf', function (Container $app) {
            return new NotyfFactory($app['flasher.event_dispatcher']);
        });

        $this->app->singleton('flasher.renderer.notyf', function (Container $app) {
            return new NotyfRenderer($app['flasher.config']);
        });

        $this->app->alias('flasher.factory.notyf', 'Flasher\Notyf\Prime\NotyfFactory');
        $this->app->alias('flasher.renderer.notyf', 'Flasher\Notyf\Prime\NotyfRenderer');

        $this->app->extend('flasher', function (Flasher $manager, Container $app) {
            $manager->addDriver($app['flasher.factory.notyf']);

            return $manager;
        });

        $this->app->extend('flasher.renderer_manager', function (RendererManager $manager, Container $app) {
            $manager->addDriver($app['flasher.renderer.notyf']);

            return $manager;
        });
    }

    public function mergeConfigFromNotyf()
    {
        $flasherConfig = $this->app['config']->get('flasher.adapters.notyf', array());

        $notyfConfig = $this->app['config']->get('flasher_notyf', array());

        $this->app['config']->set('flasher.adapters.notyf', array_merge($notyfConfig, $flasherConfig));
    }
}
