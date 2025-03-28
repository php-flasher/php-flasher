<?php

declare(strict_types=1);

namespace Flasher\Laravel;

use Flasher\Laravel\Command\InstallCommand;
use Flasher\Laravel\Component\FlasherComponent;
use Flasher\Laravel\EventListener\LivewireListener;
use Flasher\Laravel\EventListener\OctaneListener;
use Flasher\Laravel\Middleware\FlasherMiddleware;
use Flasher\Laravel\Middleware\SessionMiddleware;
use Flasher\Laravel\Storage\SessionBag;
use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Laravel\Template\BladeTemplateEngine;
use Flasher\Laravel\Translation\Translator;
use Flasher\Prime\Asset\AssetManager;
use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\ApplyPresetListener;
use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Factory\NotificationFactoryLocator;
use Flasher\Prime\Flasher;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandler;
use Flasher\Prime\Http\Csp\NonceGenerator;
use Flasher\Prime\Http\RequestExtension;
use Flasher\Prime\Http\ResponseExtension;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Storage\Filter\FilterFactory;
use Flasher\Prime\Storage\Storage;
use Flasher\Prime\Storage\StorageManager;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Octane\Events\RequestReceived;
use Livewire\LivewireManager;

/**
 * FlasherServiceProvider - Main service provider for Laravel integration.
 *
 * This class serves as the entry point for integrating PHPFlasher with Laravel.
 * It registers all necessary services, components, commands, and middleware
 * to provide a seamless Laravel experience.
 *
 * Design patterns:
 * - Service Provider: Implements Laravel's service provider pattern for registration
 * - Adapter: Adapts Laravel-specific components to PHPFlasher interfaces
 * - Bridge: Connects the framework-agnostic PHPFlasher core to Laravel
 */
final class FlasherServiceProvider extends PluginServiceProvider
{
    /**
     * Register PHPFlasher services with the Laravel container.
     *
     * This method follows Laravel's service provider registration phase by:
     * 1. Creating the core plugin
     * 2. Registering configuration
     * 3. Registering core services and adapters
     */
    public function register(): void
    {
        $this->plugin = $this->createPlugin();

        $this->registerConfiguration();
        $this->registerFlasher();
        $this->registerFactoryLocator();
        $this->registerResponseManager();
        $this->registerTemplateEngine();
        $this->registerResourceManager();
        $this->registerStorageManager();
        $this->registerEventDispatcher();
        $this->registerCspHandler();
        $this->registerAssetManager();
    }

    /**
     * Boot PHPFlasher services after all providers are registered.
     *
     * This method follows Laravel's service provider boot phase by:
     * 1. Setting up the service container bridge
     * 2. Registering commands
     * 3. Loading translations
     * 4. Registering middleware
     * 5. Registering Blade directives and components
     * 6. Setting up Livewire integration
     */
    public function boot(): void
    {
        FlasherContainer::from(static fn () => Container::getInstance());

        $this->registerCommands();
        $this->loadTranslationsFrom(__DIR__.'/Translation/lang', 'flasher');
        $this->registerMiddlewares();
        $this->callAfterResolving('blade.compiler', $this->registerBladeDirectives(...));
        $this->registerLivewire();
    }

    /**
     * Create the PHPFlasher core plugin instance.
     *
     * @return FlasherPlugin The core PHPFlasher plugin
     */
    public function createPlugin(): FlasherPlugin
    {
        return new FlasherPlugin();
    }

    /**
     * Register the main Flasher service with Laravel's container.
     *
     * This service is the main entry point for all PHPFlasher functionality
     * and is made available via the 'flasher' service binding.
     */
    private function registerFlasher(): void
    {
        $this->app->singleton('flasher', static function (Application $app) {
            $config = $app->make('config');

            $default = $config->get('flasher.default');
            $factoryLocator = $app->make('flasher.factory_locator');
            $responseManager = $app->make('flasher.response_manager');
            $storageManager = $app->make('flasher.storage_manager');

            return new Flasher($default, $factoryLocator, $responseManager, $storageManager);
        });

        $this->app->alias('flasher', Flasher::class);
        $this->app->bind(FlasherInterface::class, 'flasher');
    }

    /**
     * Register the factory locator service.
     *
     * The factory locator is responsible for locating and providing
     * notification factory instances.
     */
    private function registerFactoryLocator(): void
    {
        $this->app->singleton('flasher.factory_locator', static function () {
            return new NotificationFactoryLocator();
        });
    }

    /**
     * Register the response manager service.
     *
     * The response manager is responsible for rendering notifications
     * into different formats (HTML, JSON, etc.).
     */
    private function registerResponseManager(): void
    {
        $this->app->singleton('flasher.response_manager', static function (Application $app) {
            $resourceManager = $app->make('flasher.resource_manager');
            $storageManager = $app->make('flasher.storage_manager');
            $eventDispatcher = $app->make('flasher.event_dispatcher');

            return new ResponseManager($resourceManager, $storageManager, $eventDispatcher);
        });
    }

    /**
     * Register the template engine adapter for Blade.
     *
     * This adapter allows PHPFlasher to render templates using Laravel's Blade engine.
     */
    private function registerTemplateEngine(): void
    {
        $this->app->singleton('flasher.template_engine', static function (Application $app) {
            $viewFactory = $app->make('view');

            return new BladeTemplateEngine($viewFactory);
        });
    }

    /**
     * Register the resource manager service.
     *
     * The resource manager is responsible for managing assets (JS, CSS)
     * needed by notifications.
     */
    private function registerResourceManager(): void
    {
        $this->app->singleton('flasher.resource_manager', static function (Application $app) {
            $config = $app->make('config');

            $templateEngine = $app->make('flasher.template_engine');
            $assetManager = $app->make('flasher.asset_manager');
            $mainScript = $config->get('flasher.main_script');

            $resources = [];

            foreach ($config->get('flasher.plugins') as $name => $options) {
                $resources[$name] = $options;
            }

            foreach ($config->get('flasher.themes') as $name => $options) {
                $resources['theme.'.$name] = $options;
            }

            return new ResourceManager($templateEngine, $assetManager, $mainScript, $resources);
        });
    }

    /**
     * Register the storage manager service.
     *
     * The storage manager is responsible for storing and retrieving
     * notifications from storage (session in Laravel's case).
     */
    private function registerStorageManager(): void
    {
        $this->app->singleton('flasher.storage_manager', static function (Application $app) {
            $config = $app->make('config');

            $storageBag = new Storage(new SessionBag($app->make('session')));
            $eventDispatcher = $app->make('flasher.event_dispatcher');
            $filterFactory = new FilterFactory();
            $criteria = $config->get('flasher.filter');

            return new StorageManager($storageBag, $eventDispatcher, $filterFactory, $criteria);
        });
    }

    /**
     * Register the event dispatcher and event listeners.
     *
     * The event dispatcher is responsible for dispatching events during
     * the notification lifecycle.
     */
    private function registerEventDispatcher(): void
    {
        $this->app->singleton('flasher.notification_logger_listener', fn () => new NotificationLoggerListener());

        $this->app->singleton('flasher.event_dispatcher', static function (Application $app) {
            $config = $app->make('config');

            $eventDispatcher = new EventDispatcher();

            $translatorListener = new TranslationListener(new Translator($app->make('translator')));
            $eventDispatcher->addListener($translatorListener);

            $presetListener = new ApplyPresetListener($config->get('flasher.presets'));
            $eventDispatcher->addListener($presetListener);

            $eventDispatcher->addListener($app->make('flasher.notification_logger_listener'));

            return $eventDispatcher;
        });

        $this->callAfterResolving(Dispatcher::class, function (Dispatcher $dispatcher) {
            $dispatcher->listen(RequestReceived::class, OctaneListener::class);
        });
    }

    /**
     * Register the Artisan commands for PHPFlasher.
     *
     * Commands are only registered when running in console mode.
     */
    private function registerCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->registerAboutCommand();

        $this->app->singleton(InstallCommand::class, static function (Application $app) {
            $assetManager = $app->make('flasher.asset_manager');

            return new InstallCommand($assetManager);
        });

        $this->commands(InstallCommand::class);
    }

    /**
     * Register PHPFlasher information with Laravel's about command.
     *
     * This adds PHPFlasher information to the output of the `php artisan about` command.
     */
    private function registerAboutCommand(): void
    {
        if (!class_exists(AboutCommand::class)) {
            return;
        }

        $pluginServiceProviders = array_filter(array_keys($this->app->getLoadedProviders()), function ($provider) {
            return is_a($provider, PluginServiceProvider::class, true);
        });

        $factories = array_map(function ($providerClass) {
            /** @var PluginServiceProvider $provider */
            $provider = $this->app->getProvider($providerClass);
            $plugin = $provider->createPlugin();

            return $plugin->getAlias();
        }, $pluginServiceProviders);

        AboutCommand::add('PHPFlasher', [
            'Version' => Flasher::VERSION,
            'Factories' => implode(' <fg=gray;options=bold>/</> ', array_map(fn ($factory) => \sprintf('<fg=yellow;options=bold>%s</>', $factory), $factories)),
        ]);
    }

    /**
     * Register PHPFlasher middleware with Laravel.
     *
     * Middleware includes session processing and response modification.
     */
    private function registerMiddlewares(): void
    {
        $this->registerSessionMiddleware();
        $this->registerFlasherMiddleware();
    }

    /**
     * Register the response middleware.
     *
     * This middleware injects notification assets into responses.
     */
    private function registerFlasherMiddleware(): void
    {
        if (!$this->getConfig('inject_assets')) {
            return;
        }

        $this->app->singleton(FlasherMiddleware::class, static function (Application $app) {
            $config = $app->make('config');

            $flasher = $app->make('flasher');
            $cspHandler = $app->make('flasher.csp_handler');
            $excludedPaths = $config->get('flasher.excluded_paths', []) ?: [];

            return new FlasherMiddleware(new ResponseExtension($flasher, $cspHandler, $excludedPaths));
        });

        $this->pushMiddlewareToGroup(FlasherMiddleware::class);
    }

    /**
     * Register the session middleware.
     *
     * This middleware processes flash messages from the session.
     */
    private function registerSessionMiddleware(): void
    {
        if (!$this->getConfig('flash_bag')) {
            return;
        }

        $this->app->singleton(SessionMiddleware::class, static function (Application $app) {
            $config = $app->make('config');

            $flasher = $app->make('flasher');
            $mapping = $config->get('flasher.flash_bag', []) ?: [];

            return new SessionMiddleware(new RequestExtension($flasher, $mapping));
        });

        $this->pushMiddlewareToGroup(SessionMiddleware::class);
    }

    /**
     * Push middleware to the web middleware group.
     *
     * @param string $middleware The middleware class name
     */
    private function pushMiddlewareToGroup(string $middleware): void
    {
        $this->callAfterResolving(HttpKernel::class, function (HttpKernel $kernel) use ($middleware) {
            $kernel->appendMiddlewareToGroup('web', $middleware);
        });
    }

    /**
     * Register the Content Security Policy handler.
     *
     * This service handles CSP headers when injecting assets.
     */
    private function registerCspHandler(): void
    {
        $this->app->singleton('flasher.csp_handler', static function () {
            return new ContentSecurityPolicyHandler(new NonceGenerator());
        });
    }

    /**
     * Register the asset manager service.
     *
     * The asset manager is responsible for managing asset paths and manifests.
     */
    private function registerAssetManager(): void
    {
        $this->app->singleton('flasher.asset_manager', static function () {
            $publicDir = public_path('/');
            $manifestPath = public_path('vendor'.\DIRECTORY_SEPARATOR.'flasher'.\DIRECTORY_SEPARATOR.'manifest.json');

            return new AssetManager($publicDir, $manifestPath);
        });
    }

    /**
     * Register Blade directives and components.
     *
     * @param BladeCompiler $blade The Blade compiler instance
     */
    private function registerBladeDirectives(BladeCompiler $blade): void
    {
        $blade->directive('flasher_render', function (string $expression = '') {
            if (!empty($expression) && str_starts_with($expression, '(') && str_ends_with($expression, ')')) {
                $expression = substr($expression, 1, -1);
            }

            return "<?php app('flasher')->render('html', $expression); ?>";
        });

        $blade->component(FlasherComponent::class, 'flasher');
    }

    /**
     * Register Livewire integration.
     *
     * This sets up listeners for Livewire component lifecycle events.
     */
    private function registerLivewire(): void
    {
        if (class_exists(LivewireManager::class) && !$this->app->bound('livewire')) {
            return;
        }

        $this->callAfterResolving('livewire', function (LivewireManager $livewire, Application $app) {
            $flasher = $app->make('flasher');
            $cspHandler = $app->make('flasher.csp_handler');
            $request = fn () => $app->make('request');

            $livewire->listen('dehydrate', new LivewireListener($livewire, $flasher, $cspHandler, $request));
        });
    }
}
