<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\Config\Config;
use Flasher\LaravelFlasher\PrimeServiceProvider;
use Flasher\Laravel\Storage\Storage;
use Flasher\Prime\Filter\DefaultFilter;
use Flasher\Prime\Filter\FilterBuilder;
use Flasher\Prime\Filter\FilterManager;
use Flasher\Prime\Flasher;
use Flasher\Prime\Middleware\MiddlewareManager;
use Flasher\Prime\Presenter\Adapter\HtmlPresenter;
use Flasher\Prime\Presenter\Adapter\JsonPresenter;
use Flasher\Prime\Presenter\PresenterManager;
use Flasher\Prime\Renderer\RendererManager;
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

    public function publishConfig(NotifyServiceProvider $provider)
    {
        $source = realpath($raw = __DIR__.'/../../../resources/config/config.php') ?: $raw;

        $provider->publishes(array($source => config_path('flasher.php')), 'config');

        $provider->mergeConfigFrom($source, 'notify');
    }

    public function publishAssets(NotifyServiceProvider $provider)
    {
        $provider->publishes(array(__DIR__.'/../../../public' => public_path('vendor/php-flasher/flasher/assets/js')), 'public');
    }

    public function registerNotifyServices()
    {
        $this->app->singleton('flasher.config', function (Application $app) {
            return new Config($app['config'], '.');
        });

        $this->registerCommonServices();
    }

    public function registerCommonServices()
    {
        $this->app->singleton('flasher.factory', function (Application $app) {
            return new Flasher($app['flasher.config']);
        });

        $this->app->singleton('flasher.storage', function (Application $app) {
            return new Storage($app['session']);
        });

        $this->app->singleton('flasher.filter', function (Application $app) {
            return new FilterManager($app['flasher.config']);
        });

        $this->app->singleton('flasher.renderer', function (Application $app) {
            return new RendererManager($app['flasher.config']);
        });

        $this->app->singleton('flasher.presenter', function (Application $app) {
            return new PresenterManager();
        });

        $this->app->singleton('flasher.presenter.html', function (Application $app) {
            return new HtmlPresenter($app['flasher.config'], $app['flasher.storage'], $app['flasher.filter'], $app['flasher.renderer']);
        });

        $this->app->singleton('flasher.presenter.json', function (Application $app) {
            return new JsonPresenter($app['flasher.config'], $app['flasher.storage'], $app['flasher.filter'], $app['flasher.renderer']);
        });

        $this->app->singleton('flasher.filter_builder', function (Application $app) {
            return new FilterBuilder();
        });

        $this->app->singleton('flasher.filter.default', function (Application $app) {
            return new DefaultFilter($app['flasher.filter_builder']);
        });

        $this->app->singleton('flasher.middleware', function (Application $app) {
            return new MiddlewareManager($app['flasher.config']);
        });

        $this->app->extend('flasher.presenter', function (PresenterManager $manager, Container $app) {
            $manager->addDriver('html', $app['flasher.presenter.html']);

            return $manager;
        });

        $this->app->extend('flasher.presenter', function (PresenterManager $manager, Container $app) {
            $manager->addDriver('json', $app['flasher.presenter.json']);

            return $manager;
        });

        $this->app->extend('flasher.filter', function (FilterManager $manager, Container $app) {
            $manager->addDriver('default', $app['flasher.filter.default']);

            return $manager;
        });

        $this->app->alias('flasher.config', 'Flasher\Laravel\Config\Config');
        $this->app->alias('flasher.factory', 'Flasher\Prime\Flasher');
        $this->app->alias('flasher.presenter', 'Flasher\Prime\Presenter\PresenterManager');
        $this->app->alias('flasher.middleware', 'Flasher\Prime\Middleware\MiddlewareManager');
        $this->app->alias('flasher.storage', 'Flasher\Laravel\Storage\Storage');
        $this->app->alias('flasher.filter', 'Flasher\Prime\Filter\FilterManager');
        $this->app->alias('flasher.presenter.html', 'Flasher\Prime\Presenter\Adapter\HtmlPresenter');
        $this->app->alias('flasher.presenter.json', 'Flasher\Prime\Presenter\Adapter\JsonPresenter');
        $this->app->alias('flasher.filter_builder', 'Flasher\Prime\Filter\FilterBuilder');
        $this->app->alias('flasher.filter.default', 'Flasher\Prime\Filter\DefaultFilter');
    }

    public function registerBladeDirectives()
    {
        Blade::directive('notify_render', function ($criteria = null) {
            return "<?php echo app('flasher.presenter.html')->render($criteria); ?>";
        });
    }
}
