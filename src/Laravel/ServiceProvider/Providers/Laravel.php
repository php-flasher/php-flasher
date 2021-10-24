<?php

namespace Flasher\Laravel\ServiceProvider\Providers;

use Flasher\Laravel\Config\Config;
use Flasher\Laravel\FlasherServiceProvider;
use Flasher\Laravel\Storage\Storage;
use Flasher\Laravel\Template\BladeEngine;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\FilterListener;
use Flasher\Prime\EventDispatcher\EventListener\RemoveListener;
use Flasher\Prime\EventDispatcher\EventListener\StampsListener;
use Flasher\Prime\Factory\TemplateFactory;
use Flasher\Prime\Filter\Filter;
use Flasher\Prime\Flasher;
use Flasher\Prime\Response\Presenter\ArrayPresenter;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Storage\StorageManager;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;

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

    public function boot(FlasherServiceProvider $provider)
    {
        $provider->loadTranslationsFrom(flasher_path(__DIR__ . '/../../Resources/lang'), 'flasher');
        $provider->loadViewsFrom(flasher_path(__DIR__ . '/../../Resources/views'), 'flasher');

        $provider->publishes(array(
            flasher_path(__DIR__ . '/../../Resources/config/config.php') => config_path('flasher.php'),
        ), 'flasher-config');
        $provider->publishes(array(
            flasher_path(__DIR__ . '/../../Resources/lang') => resource_path(flasher_path('lang/vendor/flasher')),
        ), 'flasher-lang');
        $provider->publishes(array(
            flasher_path(__DIR__ . '/../../Resources/views') => resource_path(flasher_path('views/vendor/flasher')),
        ), 'flasher-views');

        $this->registerBladeDirectives();
        $this->bootServices($this->app);
    }

    /**
     * @return void
     */
    protected function bootServices(Container $app)
    {
        $templates = $app['flasher.config']->get('template_factory.templates', array());
        foreach ($templates as $template => $options) {
            $app->bind('flasher.template.'.$template, function (Application $app) use ($template) {
                $factory = new TemplateFactory($app['flasher.storage_manager']);
                $factory->setHandler('template.' . $template);

                return $factory;
            });
        }

        $app->extend('flasher', function (Flasher $flasher, Application $app) use ($templates) {
            foreach ($templates as $template => $options) {
                $flasher->addFactory('template.' . $template, $app['flasher.template.' . $template]);
            }

            return $flasher;
        });
    }

    public function register(FlasherServiceProvider $provider)
    {
        $provider->mergeConfigFrom(flasher_path(__DIR__ . '/../../Resources/config/config.php'), 'flasher');

        $this->app->singleton('flasher.config', function (Application $app) {
            return new Config($app['config'], '.');
        });

        $this->registerCommonServices();
    }

    /**
     * @return void
     */
    protected function registerCommonServices()
    {
        $this->app->singleton('flasher', function (Application $app) {
            $flasher = new Flasher($app['flasher.config'], $app['flasher.response_manager']);
            $flasher->addFactory('template', $app['flasher.template']);

            return $flasher;
        });

        $this->app->singleton('flasher.resource_manager', function (Application $app) {
            $resourceManager = new ResourceManager($app['flasher.config'], $app['flasher.template_engine']);

            $templates = $app['flasher.config']->get('template_factory.templates', array());
            foreach ($templates as $template => $factory) {
                if (isset($factory['scripts'])) {
                    $resourceManager->addScripts('template.' . $template, $factory['scripts']);
                }
                if (isset($factory['styles'])) {
                    $resourceManager->addStyles('template.' . $template, $factory['styles']);
                }
                if (isset($factory['options'])) {
                    $resourceManager->addOptions('template.' . $template, $factory['options']);
                }
            }

            return $resourceManager;
        });

        $this->app->singleton('flasher.response_manager', function (Application $app) {
            $responseManager = new ResponseManager(
                $app['flasher.storage_manager'],
                $app['flasher.event_dispatcher'],
                $app['flasher.resource_manager']
            );

            $responseManager->addPresenter('html', new HtmlPresenter());
            $responseManager->addPresenter('array', new ArrayPresenter());

            return $responseManager;
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

        $this->app->singleton('flasher.template_engine', function (Application $app) {
            return new BladeEngine($app['view']);
        });

        $this->app->singleton('flasher.event_dispatcher', function (Application $app) {
            $eventDispatcher = new EventDispatcher();

            $eventDispatcher->addSubscriber(new FilterListener($app['flasher.filter']));
            $eventDispatcher->addSubscriber(new RemoveListener());
            $eventDispatcher->addSubscriber(new StampsListener());

            return $eventDispatcher;
        });

        $this->app->singleton('flasher.template', function (Application $app) {
            return new TemplateFactory($app['flasher.storage_manager']);
        });

        $this->app->alias('flasher.config', 'Flasher\Laravel\Config\Config');
        $this->app->alias('flasher', 'Flasher\Prime\Flasher');
        $this->app->alias('flasher.response_manager', 'Flasher\Prime\Response\ResponseManager');
        $this->app->alias('flasher.event_dispatcher', 'Flasher\Prime\EventDispatcher\EventDispatcher');
        $this->app->alias('flasher.storage', 'Flasher\Laravel\Storage\Storage');
        $this->app->alias('flasher.storage_manager', 'Flasher\Laravel\Storage\StorageManager');
        $this->app->alias('flasher.filter', 'Flasher\Prime\Filter\Filter');
        $this->app->alias('flasher.template_engine', 'Flasher\Laravel\Template\BladeEngine');
        $this->app->alias('flasher.template', 'Flasher\Prime\Factory\TemplateFactory');

        $this->app->alias('flasher.template', 'flasher.notification_factory');
        $this->app->alias('flasher.template', 'Flasher\Prime\Factory\NotificationFactory');

        $this->app->bind('Flasher\Prime\Config\ConfigInterface', 'flasher.config');
        $this->app->bind('Flasher\Prime\FlasherInterface', 'flasher');
        $this->app->bind('Flasher\Prime\Storage\StorageManagerInterface', 'flasher.storage_manager');
        $this->app->bind('Flasher\Prime\Response\ResponseManagerInterface', 'flasher.response_manager');
        $this->app->bind('Flasher\Prime\Filter\FilterInterface', 'flasher.filter');
        $this->app->bind('Flasher\Prime\EventDispatcher\EventDispatcherInterface', 'flasher.event_dispatcher');
        $this->app->bind('Flasher\Prime\Storage\StorageInterface', 'flasher.storage');
        $this->app->bind('Flasher\Prime\Template\EngineInterface', 'flasher.template_engine');
        $this->app->bind('Flasher\Prime\Factory\NotificationFactoryInterface', 'flasher.template');
    }

    /**
     * @return void
     */
    protected function registerBladeDirectives()
    {
        $startsWith = function ($haystack, $needle) {
            return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
        };

        $endsWith = function ($haystack, $needle) {
            return substr_compare($haystack, $needle, -strlen($needle)) === 0;
        };

        Blade::directive('flasher_render', function ($criteria = array()) use ($startsWith, $endsWith) {
            if (!empty($criteria) && $startsWith($criteria, '(') && $endsWith($criteria, ')')) {
                $criteria = substr($criteria, 1, -1);
            }

            return "<?php echo app('flasher.response_manager')->render(${criteria}); ?>";
        });
    }
}
