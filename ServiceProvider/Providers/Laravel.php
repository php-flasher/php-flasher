<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\Config\Config;
use Flasher\Laravel\FlasherServiceProvider;
use Flasher\Laravel\Storage\Storage;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\MiddlewareListener;
use Flasher\Prime\EventDispatcher\EventListener\PostFilterListener;
use Flasher\Prime\EventDispatcher\EventListener\PostFlushListener;
use Flasher\Prime\EventDispatcher\EventListener\StorageListener;
use Flasher\Prime\Filter\DefaultFilter;
use Flasher\Prime\Filter\FilterBuilder;
use Flasher\Prime\Filter\FilterManager;
use Flasher\Prime\Flasher;
use Flasher\Prime\Middleware\AddCreatedAtStampMiddleware;
use Flasher\Prime\Middleware\AddDelayStampMiddleware;
use Flasher\Prime\Middleware\AddHopsStampMiddleware;
use Flasher\Prime\Middleware\AddPriorityStampMiddleware;
use Flasher\Prime\Middleware\FlasherBus;
use Flasher\Prime\Presenter\Adapter\HtmlPresenter;
use Flasher\Prime\Presenter\Adapter\JsonPresenter;
use Flasher\Prime\Presenter\PresenterManager;
use Flasher\Prime\Renderer\RendererManager;
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
        $source = realpath($raw = __DIR__.'/../../Resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('flasher.php')), 'config');

        $provider->mergeConfigFrom($source, 'flasher');
    }

    public function publishAssets(FlasherServiceProvider $provider)
    {
        $provider->publishes(array(__DIR__.'/../../Resources/public' => public_path('vendor/php-flasher/flasher/assets/js')), 'public');
    }

    public function publishTranslations(FlasherServiceProvider $provider)
    {
        $provider->loadTranslationsFrom(__DIR__.'/../../Resources/lang', 'flasher');
        $provider->publishes(array(__DIR__.'/../../Resources/lang' => resource_path('lang/vendor/flasher')));
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

        $this->app->singleton('flasher.renderer_manager', function (Application $app) {
            return new RendererManager($app['flasher.config']);
        });

        $this->app->singleton('flasher.flasher_bus', function (Application $app) {
            $bus = new FlasherBus();
            $bus->addMiddleware(new AddCreatedAtStampMiddleware());
            $bus->addMiddleware(new AddHopsStampMiddleware());
            $bus->addMiddleware(new AddPriorityStampMiddleware());
            $bus->addMiddleware(new AddDelayStampMiddleware());

            return $bus;
        });

        $this->app->singleton('flasher.storage', function (Application $app) {
            return new Storage($app['session']);
        });

        $this->app->singleton('flasher.storage_manager', function (Application $app) {
            return new StorageManager($app['flasher.storage'], $app['flasher.event_dispatcher']);
        });

        $this->app->singleton('flasher.event_dispatcher', function (Application $app) {
            $eventDispatcher = new EventDispatcher();
            $eventDispatcher->addSubscriber(new PostFilterListener($app['flasher.storage']));
            $eventDispatcher->addSubscriber(new PostFlushListener($app['flasher.storage']));
            $eventDispatcher->addSubscriber(new MiddlewareListener($app['flasher.flasher_bus']));
            $eventDispatcher->addSubscriber(new StorageListener($app['flasher.storage']));

            return $eventDispatcher;
        });

        $this->app->singleton('flasher.filter_manager', function (Application $app) {
            $filterManager = new FilterManager($app['flasher.config']);
            $filterManager->addDriver(new DefaultFilter($app['flasher.filter_builder']));

            return $filterManager;
        });

        $this->app->singleton('flasher.filter_builder', function (Application $app) {
            return new FilterBuilder();
        });

        $this->app->singleton('flasher.presenter_manager', function (Application $app) {
            $presenterManager = new PresenterManager($app['flasher.config']);
            $presenterManager->addDriver($app['flasher.presenter.html']);
            $presenterManager->addDriver($app['flasher.presenter.json']);

            return $presenterManager;
        });

        $this->app->singleton('flasher.presenter.html', function (Application $app) {
            return new HtmlPresenter($app['flasher.event_dispatcher'], $app['flasher.config'], $app['flasher.storage_manager'], $app['flasher.filter_manager'], $app['flasher.renderer_manager']);
        });

        $this->app->singleton('flasher.presenter.json', function (Application $app) {
            return new JsonPresenter($app['flasher.event_dispatcher'], $app['flasher.config'], $app['flasher.storage_manager'], $app['flasher.filter_manager'], $app['flasher.renderer_manager']);
        });

        $this->app->alias('flasher.config', 'Flasher\Laravel\Config\Config');
        $this->app->alias('flasher', 'Flasher\Prime\Flasher');
        $this->app->alias('flasher.presenter_manager', 'Flasher\Prime\Presenter\PresenterManager');
        $this->app->alias('flasher.renderer_manager', 'Flasher\Prime\Renderer\RendererManager');
        $this->app->alias('flasher.flasher_bus', 'Flasher\Prime\Middleware\FlasherBus');
        $this->app->alias('flasher.event_dispatcher', 'Flasher\Prime\EventDispatcher\EventDispatcher');
        $this->app->alias('flasher.storage', 'Flasher\Laravel\Storage\Storage');
        $this->app->alias('flasher.storage_manager', 'Flasher\Laravel\Storage\StorageManager');
        $this->app->alias('flasher.filter_manager', 'Flasher\Prime\Filter\FilterManager');
        $this->app->alias('flasher.filter_builder', 'Flasher\Prime\Filter\FilterBuilder');
        $this->app->alias('flasher.filter.default', 'Flasher\Prime\Filter\DefaultFilter');
        $this->app->alias('flasher.presenter.html', 'Flasher\Prime\Presenter\Adapter\HtmlPresenter');
        $this->app->alias('flasher.presenter.json', 'Flasher\Prime\Presenter\Adapter\JsonPresenter');

        $this->app->alias('flasher', 'flasher.factory_manager');

        $this->app->bind('Flasher\Prime\Config\ConfigInterface', 'flasher.config');
        $this->app->bind('Flasher\Prime\FlasherInterface', 'flasher');
        $this->app->bind('Flasher\Prime\Storage\StorageManagerInterface', 'flasher.storage_manager');
        $this->app->bind('Flasher\Prime\Renderer\RendererManagerInterface', 'flasher.renderer_manager');
        $this->app->bind('Flasher\Prime\Presenter\PresenterManagerInterface', 'flasher.presenter_manager');
        $this->app->bind('Flasher\Prime\Middleware\FlasherBusInterface', 'flasher.flasher_bus');
        $this->app->bind('Flasher\Prime\Filter\FilterManagerInterface', 'flasher.filter_manager');
        $this->app->bind('Flasher\Prime\EventDispatcher\EventDispatcherInterface', 'flasher.event_dispatcher');
        $this->app->bind('Flasher\Prime\Storage\StorageInterface', 'flasher.storage');
    }

    public function registerBladeDirectives()
    {
        Blade::directive('flasher_render', function ($criteria = null) {
            return "<?php echo app('flasher.presenter.html')->render($criteria); ?>";
        });
    }
}
