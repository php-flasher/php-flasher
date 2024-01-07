<?php

declare(strict_types=1);

namespace Flasher\Laravel;

use Flasher\Laravel\Middleware\FlasherMiddleware;
use Flasher\Laravel\Middleware\SessionMiddleware;
use Flasher\Laravel\Storage\SessionBag;
use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Laravel\Translation\Translator;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\ApplyPresetListener;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Flasher;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\RequestExtension;
use Flasher\Prime\Http\ResponseExtension;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Storage\Filter\FilterFactory;
use Flasher\Prime\Storage\Storage;
use Flasher\Prime\Storage\StorageManager;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;

final class FlasherServiceProvider extends PluginServiceProvider
{
    public function register(): void
    {
        $this->plugin = $this->createPlugin();

        $this->registerConfiguration();
        $this->registerFlasher();
        $this->registerResourceManager();
        $this->registerResponseManager();
        $this->registerStorageManager();
        $this->registerEventDispatcher();
    }

    public function boot(): void
    {
        FlasherContainer::from($this->app);

        $this->loadTranslationsFrom(__DIR__.'/Translation/lang', 'flasher');
        $this->registerMiddlewares();
    }

    protected function createPlugin(): FlasherPlugin
    {
        return new FlasherPlugin();
    }

    private function registerFlasher(): void
    {
        $this->app->singleton('flasher', static function (Application $app) {
            $config = $app->make('config')->get('flasher');
            $responseManager = $app->make('flasher.response_manager');
            $storageManager = $app->make('flasher.storage_manager');

            return new Flasher($config['default'], $responseManager, $storageManager);
        });

        $this->app->alias('flasher', Flasher::class);
        $this->app->bind(FlasherInterface::class, 'flasher');
    }

    private function registerResponseManager(): void
    {
        $this->app->singleton('flasher.response_manager', static function (Application $app) {
            $resourceManager = $app->make('flasher.resource_manager');
            $storageManager = $app->make('flasher.storage_manager');
            $eventDispatcher = $app->make('flasher.event_dispatcher');

            return new ResponseManager($resourceManager, $storageManager, $eventDispatcher);
        });
    }

    private function registerResourceManager(): void
    {
        $this->app->singleton('flasher.resource_manager', static function (Application $app) {
            $config = $app->make('config')->get('flasher');

            return new ResourceManager($config['root_script'], $config['plugins']);
        });
    }

    private function registerStorageManager(): void
    {
        $this->app->singleton('flasher.storage_manager', static function (Application $app) {
            $config = $app->make('config')->get('flasher');

            $storageBag = new Storage(new SessionBag($app->make('session')));
            $eventDispatcher = $app->make('flasher.event_dispatcher');
            $filterFactory = new FilterFactory();
            $criteria = $config['filter'];

            return new StorageManager($storageBag, $eventDispatcher, $filterFactory, $criteria);
        });
    }

    private function registerEventDispatcher(): void
    {
        $this->app->singleton('flasher.event_dispatcher', static function (Application $app) {
            $config = $app->make('config')->get('flasher');

            $eventDispatcher = new EventDispatcher();

            $translatorListener = new TranslationListener(new Translator($app->make('translator')));
            $eventDispatcher->addListener($translatorListener);

            $presetListener = new ApplyPresetListener($config['presets']);
            $eventDispatcher->addListener($presetListener);

            return $eventDispatcher;
        });
    }

    private function registerMiddlewares(): void
    {
        $this->registerSessionMiddleware();
        $this->registerFlasherMiddleware();
    }

    private function registerFlasherMiddleware(): void
    {
        $this->app->singleton(FlasherMiddleware::class, static function (Application $app) {
            $flasher = $app->make('flasher');

            return new FlasherMiddleware(new ResponseExtension($flasher));
        });

        $this->pushMiddlewareToGroup(FlasherMiddleware::class);
    }

    private function registerSessionMiddleware(): void
    {
        $this->app->singleton(SessionMiddleware::class, static function (Application $app) {
            $config = $app->make('config')->get('flasher');

            $flasher = $app->make('flasher');
            $mapping = $config['flash_bag']['mapping'];

            return new SessionMiddleware(new RequestExtension($flasher, $mapping));
        });

        $this->pushMiddlewareToGroup(SessionMiddleware::class);
    }

    private function pushMiddlewareToGroup(string $middleware): void
    {
        $this->callAfterResolving('router', function (Router $router) use ($middleware) {
            if ($router->hasMiddlewareGroup('web')) {
                $router->pushMiddlewareToGroup('web', $middleware);
            }
        });
    }
}
