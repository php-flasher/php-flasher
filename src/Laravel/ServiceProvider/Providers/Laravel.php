<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\Config\Config;
use Flasher\Laravel\NotifyServiceProvider;
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

        $provider->publishes(array($source => config_path('notify.php')), 'config');

        $provider->mergeConfigFrom($source, 'notify');
    }

    public function publishAssets(NotifyServiceProvider $provider)
    {
        $provider->publishes(array(__DIR__.'/../../../public' => public_path('vendor/php-flasher/flasher/assets/js')), 'public');
    }

    public function registerNotifyServices()
    {
        $this->app->singleton('notify.config', function (Application $app) {
            return new Config($app['config'], '.');
        });

        $this->registerCommonServices();
    }

    public function registerCommonServices()
    {
        $this->app->singleton('notify.producer', function (Application $app) {
            return new Flasher($app['notify.config']);
        });

        $this->app->singleton('notify.storage', function (Application $app) {
            return new Storage($app['session']);
        });

        $this->app->singleton('notify.filter', function (Application $app) {
            return new FilterManager($app['notify.config']);
        });

        $this->app->singleton('notify.renderer', function (Application $app) {
            return new RendererManager($app['notify.config']);
        });

        $this->app->singleton('notify.presenter', function (Application $app) {
            return new PresenterManager();
        });

        $this->app->singleton('notify.presenter.html', function (Application $app) {
            return new HtmlPresenter($app['notify.config'], $app['notify.storage'], $app['notify.filter'], $app['notify.renderer']);
        });

        $this->app->singleton('notify.presenter.json', function (Application $app) {
            return new JsonPresenter($app['notify.config'], $app['notify.storage'], $app['notify.filter'], $app['notify.renderer']);
        });

        $this->app->singleton('notify.filter_builder', function (Application $app) {
            return new FilterBuilder();
        });

        $this->app->singleton('notify.filter.default', function (Application $app) {
            return new DefaultFilter($app['notify.filter_builder']);
        });

        $this->app->singleton('notify.middleware', function (Application $app) {
            return new MiddlewareManager($app['notify.config']);
        });

        $this->app->extend('notify.presenter', function (PresenterManager $manager, Container $app) {
            $manager->addDriver('html', $app['notify.presenter.html']);

            return $manager;
        });

        $this->app->extend('notify.presenter', function (PresenterManager $manager, Container $app) {
            $manager->addDriver('json', $app['notify.presenter.json']);

            return $manager;
        });

        $this->app->extend('notify.filter', function (FilterManager $manager, Container $app) {
            $manager->addDriver('default', $app['notify.filter.default']);

            return $manager;
        });

        $this->app->alias('notify.config', 'Flasher\Laravel\Config\Config');
        $this->app->alias('notify.producer', 'Flasher\Prime\Flasher');
        $this->app->alias('notify.presenter', 'Flasher\Prime\Presenter\PresenterManager');
        $this->app->alias('notify.middleware', 'Flasher\Prime\Middleware\MiddlewareManager');
        $this->app->alias('notify.storage', 'Flasher\Laravel\Storage\Storage');
        $this->app->alias('notify.filter', 'Flasher\Prime\Filter\FilterManager');
        $this->app->alias('notify.presenter.html', 'Flasher\Prime\Presenter\Adapter\HtmlPresenter');
        $this->app->alias('notify.presenter.json', 'Flasher\Prime\Presenter\Adapter\JsonPresenter');
        $this->app->alias('notify.filter_builder', 'Flasher\Prime\Filter\FilterBuilder');
        $this->app->alias('notify.filter.default', 'Flasher\Prime\Filter\DefaultFilter');
    }

    public function registerBladeDirectives()
    {
        Blade::directive('notify_render', function ($criteria = null) {
            return "<?php echo app('notify.presenter.html')->render($criteria); ?>";
        });
    }
}
