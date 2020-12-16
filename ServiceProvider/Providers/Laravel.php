<?php

namespace Flasher\Noty\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\Noty\Laravel\FlasherNotyServiceProvider;
use Flasher\Noty\Prime\NotyFactory;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;

class Laravel implements ServiceProviderInterface
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * @inheritDoc
     */
    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    /**
     * @inheritDoc
     */
    public function boot(FlasherNotyServiceProvider $provider)
    {
        $provider->publishes(array(flasher_path(__DIR__.'/../../Resources/config/config.php') => config_path('flasher_noty.php')), 'flasher-config');
    }

    /**
     * @inheritDoc
     */
    public function register(FlasherNotyServiceProvider $provider)
    {
        $provider->mergeConfigFrom(flasher_path(__DIR__.'/../../Resources/config/config.php'), 'flasher_noty');
        $this->appendToFlasherConfig();

        $this->registerServices();
    }

    protected function registerServices()
    {
        $this->app->singleton('flasher.noty', function (Container $app) {
            return new NotyFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.noty', 'Flasher\Noty\Prime\NotyFactory');

        $this->app->extend('flasher', function (Flasher $flasher, Container $app) {
            $flasher->addFactory('noty', $app['flasher.noty']);

            return $flasher;
        });
    }

    protected function appendToFlasherConfig()
    {
        $flasherConfig = $this->app['config']->get('flasher.adapters.noty', array());

        $notyConfig = $this->app['config']->get('flasher_noty', array());

        $this->app['config']->set('flasher.adapters.noty', array_merge($notyConfig, $flasherConfig));
    }
}
