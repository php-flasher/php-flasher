<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\Config\Config;
use Flasher\Laravel\FlasherServiceProvider;
use Flasher\Laravel\Storage\Storage;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\StampsListener;
use Flasher\Prime\EventDispatcher\EventListener\FilterListener;
use Flasher\Prime\EventDispatcher\EventListener\RemoveListener;
use Flasher\Prime\Filter\Filter;
use Flasher\Prime\Flasher;
use Flasher\Prime\Renderer\Renderer;
use Flasher\Prime\Storage\StorageManager;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;

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

    public function publishConfig(FlasherServiceProvider $provider)
    {
        $source = realpath($raw = flasher_path(__DIR__.'/../../Resources/config/config.php')) ?: $raw;

        $provider->publishes(array($source => config_path('flasher.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher');
    }

    public function publishAssets(FlasherServiceProvider $provider)
    {
        $provider->publishes(array(flasher_path(__DIR__.'/../../Resources/public') => public_path(flasher_path('vendor/php-flasher/flasher/assets/js'))), 'public');
    }

    public function publishTranslations(FlasherServiceProvider $provider)
    {
        $provider->loadTranslationsFrom(flasher_path(__DIR__.'/../../Resources/lang'), 'flasher');
        $provider->publishes(array(flasher_path(__DIR__.'/../../Resources/lang') => resource_path(flasher_path('lang/vendor/flasher'))));
    }

    public function registerServices()
    {
        $this->app->singleton('flasher.config', function (Application $app) {
            return new Config($app['config'], '.');
        });

        $this->registerCommonServices();
    }

    public function registerCommonServices()
    {
        $this->app->singleton('flasher', function (Application $app) {
            return new Flasher($app['flasher.config']);
        });

        $this->app->singleton('flasher.renderer', function (Application $app) {
            return new Renderer($app['flasher.storage_manager'], $app['flasher.event_dispatcher'], $app['flasher.config']);
        });

        $this->app->singleton('flasher.storage', function (Application $app) {
            return new Storage($app['session']);
        });

        $this->app->singleton('flasher.storage_manager', function (Application $app) {
            return new StorageManager($app['flasher.storage'], $app['flasher.event_dispatcher']);
        });

        $this->app->singleton('flasher.filter', function (Application $app) {
            return new Filter();
        });

        $this->app->singleton('flasher.event_dispatcher', function (Application $app) {
            $eventDispatcher = new EventDispatcher();

            $eventDispatcher->addSubscriber(new FilterListener($app['flasher.filter']));
            $eventDispatcher->addSubscriber(new RemoveListener());
            $eventDispatcher->addSubscriber(new StampsListener());

            return $eventDispatcher;
        });

        $this->app->alias('flasher.config', 'Flasher\Laravel\Config\Config');
        $this->app->alias('flasher', 'Flasher\Prime\Flasher');
        $this->app->alias('flasher.renderer', 'Flasher\Prime\Renderer\Renderer');
        $this->app->alias('flasher.event_dispatcher', 'Flasher\Prime\EventDispatcher\EventDispatcher');
        $this->app->alias('flasher.storage', 'Flasher\Laravel\Storage\Storage');
        $this->app->alias('flasher.storage_manager', 'Flasher\Laravel\Storage\StorageManager');
        $this->app->alias('flasher.filter', 'Flasher\Prime\Filter\Filter');


        $this->app->bind('Flasher\Prime\Config\ConfigInterface', 'flasher.config');
        $this->app->bind('Flasher\Prime\FlasherInterface', 'flasher');
        $this->app->bind('Flasher\Prime\Storage\StorageManagerInterface', 'flasher.storage_manager');
        $this->app->bind('Flasher\Prime\Renderer\RendererInterface', 'flasher.renderer');
        $this->app->bind('Flasher\Prime\Filter\FilterInterface', 'flasher.filter');
        $this->app->bind('Flasher\Prime\EventDispatcher\EventDispatcherInterface', 'flasher.event_dispatcher');
        $this->app->bind('Flasher\Prime\Storage\StorageInterface', 'flasher.storage');
    }

    public function registerBladeDirectives()
    {
        Blade::directive('flasher_render', function ($criteria = array()) {
            if (empty($criteria)) {
                $criteria = "array()";
            }
            return "<?php echo app('flasher.renderer')->render($criteria, 'html'); ?>";
        });
    }
}
