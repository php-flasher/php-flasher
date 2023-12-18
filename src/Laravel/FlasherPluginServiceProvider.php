<?php

declare(strict_types=1);

namespace Flasher\Laravel;

use Flasher\Laravel\Middleware\FlasherMiddleware;
use Flasher\Laravel\Middleware\SessionMiddleware;
use Flasher\Laravel\Storage\SessionBag;
use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Laravel\Translation\Translator;
use Flasher\Prime\Config\Config;
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
use Flasher\Prime\Storage\Storage;
use Flasher\Prime\Storage\StorageManager;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;

final class FlasherPluginServiceProvider extends PluginServiceProvider
{
    protected function afterBoot(): void
    {
        FlasherContainer::from($this->app);

        $this->registerTranslations();
        $this->registerMiddlewares();
    }

    public function createPlugin(): FlasherPlugin
    {
        return new FlasherPlugin();
    }

    protected function afterRegister(): void
    {
        $this->registerConfig();
        $this->registerFlasher();
        $this->registerResourceManager();
        $this->registerResponseManager();
        $this->registerStorageManager();
        $this->registerEventDispatcher();
    }

    private function registerConfig(): void
    {
        $this->app->singleton('flasher.config', static function (Application $app): Config {
            /** @var Repository $config */
            $config = $app->make('config');

            return new Config($config->get('flasher', []));
        });
    }

    private function registerFlasher(): void
    {
        $this->app->singleton('flasher', static function (Application $app): Flasher {
            $config = $app->make('flasher.config');
            $responseManager = $app->make('flasher.response_manager');
            $storageManager = $app->make('flasher.storage_manager');

            return new Flasher($config->get('default'), $responseManager, $storageManager);
        });
        $this->app->alias('flasher', Flasher::class);
        $this->app->bind(FlasherInterface::class, 'flasher');
    }

    private function registerResourceManager(): void
    {
        $this->app->singleton('flasher.resource_manager', static function (Application $app): ResourceManager {
            $config = $app->make('flasher.config');
            $view = $app->make('view');

            return new ResourceManager($config);
        });
    }

    private function registerResponseManager(): void
    {
        $this->app->singleton('flasher.response_manager', static function (Application $app): ResponseManager {
            $resourceManager = $app->make('flasher.resource_manager');
            $storageManager = $app->make('flasher.storage_manager');
            $eventDispatcher = $app->make('flasher.event_dispatcher');

            return new ResponseManager($resourceManager, $storageManager, $eventDispatcher);
        });
    }

    private function registerStorageManager(): void
    {
        $this->app->singleton('flasher.storage_manager', static function (Application $app): StorageManager {
            $config = $app->make('flasher.config');
            $eventDispatcher = $app->make('flasher.event_dispatcher');
            $session = $app->make('session');
            /** @phpstan-ignore-next-line */
            $storageBag = new Storage(new SessionBag($session));
            $criteria = $config->get('filter_criteria', []);

            return new StorageManager($storageBag, $eventDispatcher, $criteria);
        });
    }

    private function registerEventDispatcher(): void
    {
        $this->app->singleton('flasher.event_dispatcher', static function (Application $app): EventDispatcher {
            $eventDispatcher = new EventDispatcher();
            $config = $app->make('flasher.config');
            /** @phpstan-ignore-next-line */
            $translator = new Translator($app->make('translator'));
            /** @phpstan-ignore-next-line */
            $autoTranslate = $config->get('auto_translate', true);
            $translatorListener = new TranslationListener($translator, $autoTranslate);
            $eventDispatcher->addSubscriber($translatorListener);
            $presetListener = new ApplyPresetListener($config->get('presets', []));
            // @phpstan-ignore-line
            $eventDispatcher->addSubscriber($presetListener);

            return $eventDispatcher;
        });
    }

    private function registerTranslations(): void
    {
        /** @var \Illuminate\Translation\Translator $translator */
        $translator = $this->app->make('translator');
        $translator->addNamespace('flasher', __DIR__.'/Translation/lang');
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
            $config = $app->make('flasher.config');
            $mapping = $config->get('flash_bag.mapping', []);
            $flasher = $app->make('flasher');

            return new SessionMiddleware(new RequestExtension($flasher, $mapping));
        });

        $this->pushMiddlewareToGroup(SessionMiddleware::class);
    }

    private function pushMiddlewareToGroup(string $middleware): void
    {
        $router = $this->app->make('router');

        if ($router instanceof Router && $router->hasMiddlewareGroup('web')) {
            $router->pushMiddlewareToGroup('web', $middleware);
        }
    }
}
