<?php

namespace Flasher\Pnotify\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\ServiceProvider\ResourceManagerHelper;
use Flasher\Pnotify\Laravel\FlasherPnotifyServiceProvider;
use Flasher\Pnotify\Prime\PnotifyFactory;
use Flasher\Prime\Flasher;
use Flasher\Prime\Response\Resource\ResourceManager;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;

class Laravel implements ServiceProviderInterface
{
    /**
     * @var Container
     */
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function shouldBeUsed()
    {
        return $this->app instanceof Application;
    }

    public function boot(FlasherPnotifyServiceProvider $provider)
    {
        $provider->publishes(array(
            flasher_path(__DIR__ . '/../../Resources/config/config.php') => config_path('flasher_pnotify.php'),
        ), 'flasher-config');
    }

    public function register(FlasherPnotifyServiceProvider $provider)
    {
        $provider->mergeConfigFrom(flasher_path(__DIR__ . '/../../Resources/config/config.php'), 'flasher_pnotify');
        $this->appendToFlasherConfig();

        $this->registerServices();
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.pnotify', function (Container $app) {
            return new PnotifyFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.pnotify', 'Flasher\Pnotify\Prime\PnotifyFactory');

        $this->app->extend('flasher', function (Flasher $manager, Container $app) {
            $manager->addFactory('pnotify', $app['flasher.pnotify']);

            return $manager;
        });

        $this->app->extend('flasher.resource_manager', function (ResourceManager $resourceManager) {
            ResourceManagerHelper::process($resourceManager, 'pnotify');

            return $resourceManager;
        });
    }

    protected function appendToFlasherConfig()
    {
        $flasherConfig = $this->app['config']->get('flasher.adapters.pnotify', array());

        $pnotifyConfig = $this->app['config']->get('flasher_pnotify', array());

        $this->app['config']->set('flasher.adapters.pnotify', array_merge($pnotifyConfig, $flasherConfig));
    }
}
