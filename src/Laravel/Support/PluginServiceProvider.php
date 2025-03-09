<?php

declare(strict_types=1);

namespace Flasher\Laravel\Support;

use Flasher\Prime\Factory\NotificationFactoryLocator;
use Flasher\Prime\Plugin\PluginInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Support\ServiceProvider;

/**
 * PluginServiceProvider - Base service provider for PHPFlasher plugins.
 *
 * This abstract class provides the foundation for all PHPFlasher plugin
 * service providers in Laravel. It handles the registration of plugin
 * configuration, factories, and services.
 *
 * Design patterns:
 * - Template Method: Defines the skeleton of registration process with customizable steps
 * - Factory: Creates plugin instances via createPlugin method
 * - Service Provider: Implements Laravel's service provider pattern
 *
 * Plugin providers should extend this class and implement the createPlugin method.
 */
abstract class PluginServiceProvider extends ServiceProvider
{
    /**
     * The plugin instance.
     */
    protected PluginInterface $plugin;

    /**
     * Create the plugin instance.
     *
     * Child classes must implement this method to provide their specific plugin.
     *
     * @return PluginInterface The plugin instance
     */
    abstract public function createPlugin(): PluginInterface;

    /**
     * Register services with the Laravel container.
     *
     * This method:
     * 1. Creates the plugin instance
     * 2. Registers plugin configuration
     * 3. Calls the afterRegister hook for customization
     */
    public function register(): void
    {
        $this->plugin = $this->createPlugin();

        $this->registerConfiguration();
        $this->afterRegister();
    }

    /**
     * Bootstrap services after all providers are registered.
     *
     * This method:
     * 1. Registers the plugin factory
     * 2. Calls the afterBoot hook for customization
     */
    public function boot(): void
    {
        $this->registerFactory();
        $this->afterBoot();
    }

    /**
     * Get the plugin's configuration file path.
     *
     * @return string The absolute path to the configuration file
     */
    public function getConfigurationFile(): string
    {
        return rtrim($this->getResourcesDir(), '/').'/config.php';
    }

    /**
     * Get a configuration value with optional default.
     *
     * @param string|null $key     The configuration key to retrieve, or null for all config
     * @param mixed       $default The default value to return if the key doesn't exist
     *
     * @return mixed The configuration value
     */
    protected function getConfig(?string $key = null, mixed $default = null): mixed
    {
        /** @var Repository $config */
        $config = $this->app->make('config');

        return $key ? $config->get('flasher.'.$key, $default) : $config->get('flasher');
    }

    /**
     * Get the plugin's resources directory path.
     *
     * @return string The absolute path to the resources directory
     */
    protected function getResourcesDir(): string
    {
        $r = new \ReflectionClass($this);

        return pathinfo($r->getFileName() ?: '', \PATHINFO_DIRNAME).'/Resources/';
    }

    /**
     * Register the plugin's configuration.
     *
     * This method merges the plugin's default configuration with any user-defined
     * configuration and registers it with Laravel's config repository.
     */
    protected function registerConfiguration(): void
    {
        if ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached()) {
            return;
        }

        $alias = $this->plugin->getAlias();
        $config = $this->app->make('config');

        $key = 'flasher' === $alias ? $alias : "flasher.plugins.$alias";
        /**
         * @var array{
         *      scripts?: string|string[],
         *      styles?: string|string[],
         *      options?: array<string, mixed>,
         *  } $current
         */
        $current = $config->get($key, []);

        $config->set($key, $this->plugin->normalizeConfig($current));
    }

    /**
     * Hook method executed after registration.
     *
     * Child classes can override this method to add custom registration logic.
     */
    protected function afterRegister(): void
    {
    }

    /**
     * Hook method executed after boot.
     *
     * Child classes can override this method to add custom boot logic.
     */
    protected function afterBoot(): void
    {
    }

    /**
     * Register the plugin's notification factory.
     *
     * This method:
     * 1. Registers the factory as a singleton
     * 2. Registers any aliases for the factory
     * 3. Adds the factory to the factory locator
     */
    protected function registerFactory(): void
    {
        $this->app->singleton($this->plugin->getServiceId(), function (Application $app) {
            $factory = $this->plugin->getFactory();

            return new $factory($app->make('flasher.storage_manager'));
        });

        $identifier = $this->plugin->getServiceId();
        foreach ((array) $this->plugin->getServiceAliases() as $alias) {
            $this->app->alias($identifier, $alias);
        }

        $this->app->extend('flasher.factory_locator', function (NotificationFactoryLocator $factoryLocator, Application $app) {
            $factoryLocator->addFactory($this->plugin->getAlias(), fn () => $app->make($this->plugin->getServiceId()));

            return $factoryLocator;
        });
    }
}
