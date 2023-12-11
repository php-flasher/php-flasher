<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
use Flasher\Prime\EventDispatcher\EventListener\PresetListener;
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
use Livewire\Mechanisms\HandleComponents\ComponentContext;
use Livewire\Response;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class FlasherServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function afterBoot()
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
    public function createPlugin()
    {
        return new FlasherPlugin();
    }

    /**
     * {@inheritdoc}
     */
    protected function afterRegister()
    {
        $this->registerConfig();
        $this->registerFlasher();
        $this->registerResourceManager();
        $this->registerResponseManager();
        $this->registerStorageManager();
        $this->registerEventDispatcher();
    }

    /**
     * @return void
     */
    private function registerCommands()
    {
        if (!in_array(\PHP_SAPI, array('cli', 'phpdbg'))) {
            return;
        }

        $this->commands(array(
            'Flasher\Laravel\Command\InstallCommand', // flasher:install
        ));
    }

    /**
     * @return void
     */
    private function registerConfig()
    {
        $this->app->singleton('flasher.config', function (Application $app) {
            /** @var Repository $config */
            $config = $app->make('config');

            return new Config($config->get('flasher', array())); // @phpstan-ignore-line
        });
    }

    /**
     * @return void
     */
    private function registerFlasher()
    {
        $this->app->singleton('flasher', function (Application $app) {
            $config = $app->make('flasher.config');
            $responseManager = $app->make('flasher.response_manager');
            $storageManager = $app->make('flasher.storage_manager');

            return new Flasher($config->get('default'), $responseManager, $storageManager); // @phpstan-ignore-line
        });
        $this->app->alias('flasher', 'Flasher\Prime\Flasher');
        $this->app->bind('Flasher\Prime\FlasherInterface', 'flasher');
    }

    /**
     * @return void
     */
    private function registerResourceManager()
    {
        $this->app->singleton('flasher.resource_manager', function (Application $app) {
            $config = $app->make('flasher.config');
            $view = $app->make('view');

            return new ResourceManager($config, new BladeTemplateEngine($view)); // @phpstan-ignore-line
        });
    }

    /**
     * @return void
     */
    private function registerResponseManager()
    {
        $this->app->singleton('flasher.response_manager', function (Application $app) {
            $resourceManager = $app->make('flasher.resource_manager');
            $storageManager = $app->make('flasher.storage_manager');
            $eventDispatcher = $app->make('flasher.event_dispatcher');

            return new ResponseManager($resourceManager, $storageManager, $eventDispatcher); // @phpstan-ignore-line
        });
    }

    /**
     * @return void
     */
    private function registerStorageManager()
    {
        $this->app->singleton('flasher.storage_manager', function (Application $app) {
            $config = $app->make('flasher.config');
            $eventDispatcher = $app->make('flasher.event_dispatcher');
            $session = $app->make('session');

            /** @phpstan-ignore-next-line */
            $storageBag = new StorageBag(new SessionBag($session));

            $criteria = $config->get('filter_criteria', array()); // @phpstan-ignore-line

            return new StorageManager($storageBag, $eventDispatcher, $criteria); // @phpstan-ignore-line
        });
    }

    /**
     * @return void
     */
    private function registerEventDispatcher()
    {
        $this->app->singleton('flasher.event_dispatcher', function (Application $app) {
            $eventDispatcher = new EventDispatcher();
            $config = $app->make('flasher.config');

            /** @phpstan-ignore-next-line */
            $translator = new Translator($app->make('translator'));

            /** @phpstan-ignore-next-line */
            $autoTranslate = $config->get('auto_translate', true);

            $translatorListener = new TranslationListener($translator, $autoTranslate);
            $eventDispatcher->addSubscriber($translatorListener);

            $presetListener = new PresetListener($config->get('presets', array())); // @phpstan-ignore-line
            $eventDispatcher->addSubscriber($presetListener);

            return $eventDispatcher;
        });
    }

    /**
     * @return void
     */
    private function registerTranslations()
    {
        /** @var \Illuminate\Translation\Translator $translator */
        $translator = $this->app->make('translator');
        $translator->addNamespace('flasher', __DIR__.'/Translation/lang');
    }

    /**
     * @return void
     */
    private function registerLivewire()
    {
        if (!$this->app->bound('livewire')) {
            return;
        }

        $livewire = $this->app->make('livewire');
        if (!$livewire instanceof LivewireManager) {
            return;
        }

        // Livewire v3
        if (method_exists($livewire, 'componentHook')) {
            $livewire->listen('dehydrate', function (Component $component, ComponentContext $context) {
                if ($context->mounting || isset($context->effects['redirect'])) {
                    return;
                }

                /** @var FlasherInterface $flasher */
                $flasher = app('flasher');

                /** @var array{envelopes: Envelope[]} $data */
                $data = $flasher->render(array(), 'array');

                if (\count($data['envelopes']) > 0) {
                    $data['context']['livewire'] = array(
                        'id' => $component->getId(),
                        'name' => $component->getName(),
                    );

                    $dispatches = isset($context->effects['dispatches']) ? $context->effects['dispatches'] : [];
                    $dispatches[] = array('name' => 'flasher:render', 'params' => $data);

                    $context->addEffect('dispatches', $dispatches);
                }
            });

            return;
        }

        $livewire->listen('component.dehydrate.subsequent', function (Component $component, Response $response) {
            if (isset($response->effects['redirect'])) {
                return;
            }

            /** @var FlasherInterface $flasher */
            $flasher = app('flasher');

            /** @var array{envelopes: Envelope[]} $data */
            $data = $flasher->render(array(), 'array');

            if (\count($data['envelopes']) > 0) {
                $data['context']['livewire'] = array(
                    'id' => $component->id,
                    'name' => $response->fingerprint['name'],
                );

                $response->effects['dispatches'][] = array(
                    'event' => 'flasher:render',
                    'data' => $data,
                );
            }
        });
    }

    /**
     * @return void
     */
    private function registerBladeDirective()
    {
        Blade::extend(function ($view) {
            $pattern = '/(?<!\w)(\s*)@flasher_(livewire_)?render(\(.*?\))?/';

            if (!preg_match($pattern, $view)) {
                return $view;
            }

            @trigger_error('Since php-flasher/flasher-laravel v1.6.0: Using @flasher_render or @flasher_livewire_render is deprecated and will be removed in v2.0. PHPFlasher will render notification automatically', \E_USER_DEPRECATED);

            return preg_replace($pattern, '', $view);
        });
    }

    /**
     * @return void
     */
    private function registerBladeComponent()
    {
        if (Laravel::isVersion('7.0', '<=')) {
            return;
        }

        Blade::component('flasher', 'Flasher\Laravel\Component\FlasherComponent');
    }

    /**
     * @return void
     */
    private function registerMiddlewares()
    {
        $this->registerSessionMiddleware();
        $this->registerFlasherMiddleware();
    }

    /**
     * @return void
     */
    private function registerFlasherMiddleware()
    {
        /** @var ConfigInterface $config */
        $config = $this->app->make('flasher.config');

        if (!$config->get('auto_render', true)) {
            return;
        }

        $this->app->singleton('Flasher\Laravel\Middleware\FlasherMiddleware', function (Application $app) {
            /** @var FlasherInterface $flasher */
            $flasher = $app->make('flasher');

            return new FlasherMiddleware(new ResponseExtension($flasher));
        });

        $this->appendMiddlewareToWebGroup('Flasher\Laravel\Middleware\FlasherMiddleware');

        if (method_exists($this->app, 'middleware')) {
            $this->app->middleware(new HttpKernelFlasherMiddleware($this->app)); // @phpstan-ignore-line
        }
    }

    /**
     * @return void
     */
    private function registerSessionMiddleware()
    {
        /** @var ConfigInterface $config */
        $config = $this->app->make('flasher.config');

        if (!$config->get('flash_bag.enabled', true)) {
            return;
        }

        $this->app->singleton('Flasher\Laravel\Middleware\SessionMiddleware', function (Application $app) {
            /** @var ConfigInterface $config */
            $config = $app->make('flasher.config');
            $mapping = $config->get('flash_bag.mapping', array());
            $flasher = $app->make('flasher');

            return new SessionMiddleware(new RequestExtension($flasher, $mapping)); // @phpstan-ignore-line
        });

        $this->appendMiddlewareToWebGroup('Flasher\Laravel\Middleware\SessionMiddleware');

        if (method_exists($this->app, 'middleware')) {
            $this->app->middleware(new HttpKernelSessionMiddleware($this->app)); // @phpstan-ignore-line
        }
    }

    /**
     * @param string $middleware
     *
     * @return void
     */
    private function appendMiddlewareToWebGroup($middleware)
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

        if (!$this->app->bound('Illuminate\Contracts\Http\Kernel')) {
            return;
        }

        /** @var Kernel $kernel */
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');

        if (method_exists($kernel, 'appendMiddlewareToGroup')) {
            $kernel->appendMiddlewareToGroup('web', $middleware);

            return;
        }

        if (method_exists($kernel, 'pushMiddleware')) {
            $kernel->pushMiddleware($middleware);
        }
    }
}
