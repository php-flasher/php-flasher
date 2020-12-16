<?php

namespace Flasher\SweetAlert\Laravel\ServiceProvider\Providers;

use Flasher\Prime\Flasher;
use Flasher\SweetAlert\Laravel\FlasherSweetAlertServiceProvider;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
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
    public function boot(FlasherSweetAlertServiceProvider $provider)
    {
        $provider->publishes(array(flasher_path(__DIR__.'/../../Resources/config/config.php') => config_path('flasher_sweet_alert.php')), 'config');
    }

    /**
     * @inheritDoc
     */
    public function register(FlasherSweetAlertServiceProvider $provider)
    {
        $provider->mergeConfigFrom(flasher_path(__DIR__.'/../../Resources/config/config.php'), 'flasher_sweet_alert');
        $this->appendToFlasherConfig();

        $this->registerServices();
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.sweet_alert', function (Container $app) {
            return new SweetAlertFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.sweet_alert', 'Flasher\SweetAlert\Prime\SweetAlertFactory');

        $this->app->extend('flasher', function (Flasher $manager, Container $app) {
            $manager->addFactory('sweet_alert', $app['flasher.sweet_alert']);

            return $manager;
        });
    }

    public function appendToFlasherConfig()
    {
        $notifyConfig = $this->app['config']->get('flasher.adapters.sweet_alert', array());

        $sweetAlertConfig = $this->app['config']->get('flasher_sweet_alert', array());

        $this->app['config']->set('flasher.adapters.sweet_alert', array_merge($sweetAlertConfig, $notifyConfig));
    }
}
