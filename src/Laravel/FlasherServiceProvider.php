<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel;

use Flasher\Laravel\Middleware\HttpKernelFlasherMiddleware;
use Flasher\Laravel\Middleware\HttpKernelSessionMiddleware;
use Flasher\Laravel\Middleware\SessionMiddleware;
use Flasher\Laravel\Storage\SessionBag;
use Flasher\Laravel\Support\Laravel;
use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Laravel\Template\BladeTemplateEngine;
use Flasher\Laravel\Translation\Translator;
use Flasher\Prime\Config\Config;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\PresetListener;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Flasher;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Storage\StorageBag;
use Flasher\Prime\Storage\StorageManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Component;
use Livewire\LivewireManager;
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
        $this->registerBladeDirective();
        $this->registerBladeComponent();
        $this->registerLivewire();
        $this->registerTranslations();
        $this->appendSessionMiddlewareToWebGroup();
    }

    /**
     * @{@inheritdoc}
     */
    protected function createPlugin()
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
        $this->registerSessionMiddleware();
    }

    /**
     * @return void
     */
    private function registerConfig()
    {
        $this->app->singleton('flasher.config', function (Application $app) {
            return new Config($app['config']->get('flasher')); // @phpstan-ignore-line
        });
    }

    /**
     * @return void
     */
    private function registerFlasher()
    {
        $this->app->singleton('flasher', function (Application $app) {
            return new Flasher($app['flasher.config']->get('default'), $app['flasher.response_manager'], $app['flasher.storage_manager']); // @phpstan-ignore-line
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
            return new ResourceManager($app['flasher.config'], new BladeTemplateEngine($app['view'])); // @phpstan-ignore-line
        });
    }

    /**
     * @return void
     */
    private function registerResponseManager()
    {
        $this->app->singleton('flasher.response_manager', function (Application $app) {
            return new ResponseManager($app['flasher.resource_manager'], $app['flasher.storage_manager'], $app['flasher.event_dispatcher']); // @phpstan-ignore-line
        });
    }

    /**
     * @return void
     */
    private function registerStorageManager()
    {
        $this->app->singleton('flasher.storage_manager', function (Application $app) {
            return new StorageManager(new StorageBag(new SessionBag($app['session'])), $app['flasher.event_dispatcher']); // @phpstan-ignore-line
        });
    }

    /**
     * @return void
     */
    private function registerEventDispatcher()
    {
        $this->app->singleton('flasher.event_dispatcher', function (Application $app) {
            $eventDispatcher = new EventDispatcher();

            $eventDispatcher->addSubscriber(new TranslationListener(
                new Translator($app['translator']), // @phpstan-ignore-line
                $app['flasher.config']->get('auto_translate') // @phpstan-ignore-line
            ));

            $eventDispatcher->addSubscriber(new PresetListener(
                $app['flasher.config']->get('presets', array()) // @phpstan-ignore-line
            ));

            return $eventDispatcher;
        });
    }

    /**
     * @return void
     */
    private function registerSessionMiddleware()
    {
        $config = $this->app['flasher.config']; // @phpstan-ignore-line
        if (true !== $config->get('flash_bag.enabled', false)) {
            return;
        }

        $mapping = $config->get('flash_bag.mapping', array());
        $this->app->singleton('Flasher\Laravel\Middleware\SessionMiddleware', function (Application $app) use ($mapping) {
            return new SessionMiddleware($app['flasher'], $mapping); // @phpstan-ignore-line
        });

        if (method_exists($this->app, 'middleware')) {
            $this->app->middleware(new HttpKernelFlasherMiddleware($this->app));
            $this->app->middleware(new HttpKernelSessionMiddleware($this->app));
        }
    }

    /**
     * @return void
     */
    private function registerTranslations()
    {
        /** @var \Illuminate\Translation\Translator $translator */
        $translator = $this->app['translator'];
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

        $livewire->listen('component.dehydrate.subsequent', function (Component $component, Response $response) {
            if (isset($response->effects['redirect'])) {
                return;
            }

            $data = app('flasher')->render(array(), 'array'); // @phpstan-ignore-line

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
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function registerBladeDirective()
    {
        $startsWith = function ($haystack, $needle) {
            return 0 === substr_compare($haystack, $needle, 0, \strlen($needle));
        };

        $endsWith = function ($haystack, $needle) {
            return 0 === substr_compare($haystack, $needle, -\strlen($needle));
        };

        if (Laravel::isVersion('5.1', '>=')) {
            Blade::directive('flasher_render', function ($criteria = array()) use ($startsWith, $endsWith) {
                if (!empty($criteria) && $startsWith($criteria, '(') && $endsWith($criteria, ')')) {
                    $criteria = substr($criteria, 1, -1);
                }

                return "<?php echo app('flasher')->render({$criteria}); ?>";
            });

            Blade::directive('flasher_livewire_render', function () {
                @trigger_error('Since php-flasher/flasher-laravel v1.0: Using @flasher_livewire_render is deprecated and will be removed in v2.0. Use flasher_render instead.', \E_USER_DEPRECATED);

                return '';
            });

            return;
        }

        if (Laravel::isVersion('5.0', '>=')) {
            Blade::extend(function ($view, BladeCompiler $compiler) use ($startsWith, $endsWith) {
                if (!method_exists($compiler, 'createPlainMatcher')) {
                    return '';
                }

                $pattern = $compiler->createPlainMatcher('flasher_render(.*)');
                $matches = array();

                preg_match($pattern, $view, $matches);

                $value = $matches[2];

                if (!empty($value) && $startsWith($value, '(') && $endsWith($value, ')')) {
                    $value = substr($value, 1, -1);
                }

                return str_replace(
                    '%criteria%',
                    $value,
                    $matches[1]."<?php echo app('flasher')->render(%criteria%); ?>"
                );
            });

            return;
        }

        Blade::extend(function ($view, BladeCompiler $compiler) {
            if (!method_exists($compiler, 'createMatcher')) {
                return '';
            }

            $pattern = $compiler->createMatcher('flasher_render');

            return preg_replace($pattern, '$1<?php echo app(\'flasher\')->render$2; ?>', $view);
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

        if (!$this->app->bound('blade.compiler')) {
            return;
        }

        $compiler = $this->app->make('blade.compiler');
        if (!method_exists($compiler, 'component')) {
            return;
        }

        Blade::component('flasher', 'Flasher\Laravel\Component\FlasherComponent');
    }

    /**
     * @return void
     */
    private function appendSessionMiddlewareToWebGroup()
    {
        /** @var \Illuminate\Routing\Router $router */
        $router = $this->app['router'];
        if (method_exists($router, 'pushMiddlewareToGroup')) {
            $router->pushMiddlewareToGroup('web', 'Flasher\Laravel\Middleware\FlasherMiddleware');
            $router->pushMiddlewareToGroup('web', 'Flasher\Laravel\Middleware\SessionMiddleware');

            return;
        }

        if (!$this->app->bound('Illuminate\Contracts\Http\Kernel')) {
            return;
        }

        /** @var \Illuminate\Foundation\Http\Kernel $kernel */
        $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];

        if (method_exists($kernel, 'appendMiddlewareToGroup')) {
            $kernel->appendMiddlewareToGroup('web', 'Flasher\Laravel\Middleware\FlasherMiddleware');
            $kernel->appendMiddlewareToGroup('web', 'Flasher\Laravel\Middleware\SessionMiddleware');

            return;
        }

        if (method_exists($kernel, 'pushMiddleware')) {
            $kernel->pushMiddleware('Flasher\Laravel\Middleware\FlasherMiddleware');
            $kernel->pushMiddleware('Flasher\Laravel\Middleware\SessionMiddleware');

            return;
        }
    }
}
