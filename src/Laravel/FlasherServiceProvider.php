<?php

declare(strict_types=1);

namespace Flasher\Laravel;

use Flasher\Laravel\Container\LaravelContainer;
use Flasher\Laravel\Middleware\FlasherMiddleware;
use Flasher\Laravel\Middleware\HttpKernelFlasherMiddleware;
use Flasher\Laravel\Middleware\HttpKernelSessionMiddleware;
use Flasher\Laravel\Middleware\SessionMiddleware;
use Flasher\Laravel\Storage\SessionBag;
use Flasher\Laravel\Support\Laravel;
use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Laravel\Template\BladeTemplateEngine;
use Flasher\Laravel\Translation\Translator;
use Flasher\Prime\Config\Config;
use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\ApplyPresetListener;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Flasher;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\RequestExtension;
use Flasher\Prime\Http\ResponseExtension;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Storage\StorageBag;
use Flasher\Prime\Storage\StorageManager;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Livewire\LivewireManager;
use Livewire\Response;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class FlasherServiceProvider extends ServiceProvider
{
    protected function afterBoot(): void
    {
        FlasherContainer::init(new LaravelContainer());

        $this->registerCommands();
        $this->registerBladeDirective();
        $this->registerBladeComponent();
        $this->registerLivewire();
        $this->registerTranslations();
        $this->registerMiddlewares();
    }

    /**
     * @{@inheritdoc}
     */
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

    private function registerCommands(): void
    {
        if (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'])) {
            return;
        }

        $this->commands([
            \Flasher\Laravel\Command\InstallCommand::class, // flasher:install
        ]);
    }

    private function registerConfig(): void
    {
        $this->app->singleton('flasher.config', static function (Application $app): Config {
            /** @var Repository $config */
            $config = $app->make('config');

            return new Config($config->get('flasher', []));
            // @phpstan-ignore-line
        });
    }

    private function registerFlasher(): void
    {
        $this->app->singleton('flasher', static function (Application $app): Flasher {
            $config = $app->make('flasher.config');
            $responseManager = $app->make('flasher.response_manager');
            $storageManager = $app->make('flasher.storage_manager');

            return new Flasher($config->get('default'), $responseManager, $storageManager);
            // @phpstan-ignore-line
        });
        $this->app->alias('flasher', \Flasher\Prime\Flasher::class);
        $this->app->bind(\Flasher\Prime\FlasherInterface::class, 'flasher');
    }

    private function registerResourceManager(): void
    {
        $this->app->singleton('flasher.resource_manager', static function (Application $app): ResourceManager {
            $config = $app->make('flasher.config');
            $view = $app->make('view');

            return new ResourceManager($config, new BladeTemplateEngine($view));
            // @phpstan-ignore-line
        });
    }

    private function registerResponseManager(): void
    {
        $this->app->singleton('flasher.response_manager', static function (Application $app): ResponseManager {
            $resourceManager = $app->make('flasher.resource_manager');
            $storageManager = $app->make('flasher.storage_manager');
            $eventDispatcher = $app->make('flasher.event_dispatcher');

            return new ResponseManager($resourceManager, $storageManager, $eventDispatcher);
            // @phpstan-ignore-line
        });
    }

    private function registerStorageManager(): void
    {
        $this->app->singleton('flasher.storage_manager', static function (Application $app): StorageManager {
            $config = $app->make('flasher.config');
            $eventDispatcher = $app->make('flasher.event_dispatcher');
            $session = $app->make('session');
            /** @phpstan-ignore-next-line */
            $storageBag = new StorageBag(new SessionBag($session));
            $criteria = $config->get('filter_criteria', []);

            // @phpstan-ignore-line
            return new StorageManager($storageBag, $eventDispatcher, $criteria);
            // @phpstan-ignore-line
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

    private function registerLivewire(): void
    {
        if (!$this->app->bound('livewire')) {
            return;
        }

        $livewire = $this->app->make('livewire');
        if (!$livewire instanceof LivewireManager) {
            return;
        }

        $livewire->listen('component.dehydrate.subsequent', static function (Component $component, Response $response): void {
            if (isset($response->effects['redirect'])) {
                return;
            }

            /** @var FlasherInterface $flasher */
            $flasher = app('flasher');
            /** @var array{envelopes: Envelope[]} $data */
            $data = $flasher->render([], 'array');
            if ([] !== $data['envelopes']) {
                $data['context']['livewire'] = [
                    'id' => $component->id,
                    'name' => $response->fingerprint['name'],
                ];

                $response->effects['dispatches'][] = [
                    'event' => 'flasher:render',
                    'data' => $data,
                ];
            }
        });
    }

    private function registerBladeDirective(): void
    {
        Blade::extend(static function ($view) {
            $pattern = '/(?<!\w)(\s*)@flasher_(livewire_)?render(\(.*?\))?/';
            if (!preg_match($pattern, $view)) {
                return $view;
            }

            @trigger_error('Since php-flasher/flasher-laravel v1.6.0: Using @flasher_render or @flasher_livewire_render is deprecated and will be removed in v2.0. PHPFlasher will render notification automatically', \E_USER_DEPRECATED);

            return preg_replace($pattern, '', $view);
        });
    }

    private function registerBladeComponent(): void
    {
        if (Laravel::isVersion('7.0', '<=')) {
            return;
        }

        Blade::component('flasher', \Flasher\Laravel\Component\FlasherComponent::class);
    }

    private function registerMiddlewares(): void
    {
        $this->registerSessionMiddleware();
        $this->registerFlasherMiddleware();
    }

    private function registerFlasherMiddleware(): void
    {
        /** @var ConfigInterface $config */
        $config = $this->app->make('flasher.config');

        if (!$config->get('auto_render', true)) {
            return;
        }

        $this->app->singleton(\Flasher\Laravel\Middleware\FlasherMiddleware::class, static function (Application $app): FlasherMiddleware {
            /** @var FlasherInterface $flasher */
            $flasher = $app->make('flasher');

            return new FlasherMiddleware(new ResponseExtension($flasher));
        });

        $this->appendMiddlewareToWebGroup(\Flasher\Laravel\Middleware\FlasherMiddleware::class);

        if (method_exists($this->app, 'middleware')) {
            $this->app->middleware(new HttpKernelFlasherMiddleware($this->app)); // @phpstan-ignore-line
        }
    }

    private function registerSessionMiddleware(): void
    {
        /** @var ConfigInterface $config */
        $config = $this->app->make('flasher.config');

        if (!$config->get('flash_bag.enabled', true)) {
            return;
        }

        $this->app->singleton(\Flasher\Laravel\Middleware\SessionMiddleware::class, static function (Application $app): SessionMiddleware {
            /** @var ConfigInterface $config */
            $config = $app->make('flasher.config');
            $mapping = $config->get('flash_bag.mapping', []);
            $flasher = $app->make('flasher');

            return new SessionMiddleware(new RequestExtension($flasher, $mapping));
            // @phpstan-ignore-line
        });

        $this->appendMiddlewareToWebGroup(\Flasher\Laravel\Middleware\SessionMiddleware::class);

        if (method_exists($this->app, 'middleware')) {
            $this->app->middleware(new HttpKernelSessionMiddleware($this->app)); // @phpstan-ignore-line
        }
    }

    private function appendMiddlewareToWebGroup(string $middleware): void
    {
        if (!$this->app->bound($middleware)) {
            return;
        }

        /** @var Router $router */
        $router = $this->app->make('router');
        if (method_exists($router, 'pushMiddlewareToGroup')) {
            $router->pushMiddlewareToGroup('web', $middleware);

            return;
        }

        if (!$this->app->bound(\Illuminate\Contracts\Http\Kernel::class)) {
            return;
        }

        /** @var Kernel $kernel */
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);

        if (method_exists($kernel, 'appendMiddlewareToGroup')) {
            $kernel->appendMiddlewareToGroup('web', $middleware);

            return;
        }

        if (method_exists($kernel, 'pushMiddleware')) {
            $kernel->pushMiddleware($middleware);
        }
    }
}
