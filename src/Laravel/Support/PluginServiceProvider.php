<?php

declare(strict_types=1);

namespace Flasher\Laravel\Support;

use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Plugin\PluginInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Support\ServiceProvider;

abstract class PluginServiceProvider extends ServiceProvider
{
    protected PluginInterface $plugin;

    abstract protected function createPlugin(): PluginInterface;

    public function register(): void
    {
        $this->plugin = $this->createPlugin();

        $this->registerConfiguration();
        $this->afterRegister();
    }

    public function boot(): void
    {
        $this->registerFactory();
        $this->afterBoot();
    }

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

    protected function afterRegister(): void
    {
    }

    protected function afterBoot(): void
    {
    }

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

        $this->callAfterResolving('flasher', function (FlasherInterface $flasher, Application $app) {
            $flasher->addFactory($this->plugin->getAlias(), fn () => $app->make($this->plugin->getServiceId()));
        });
    }
}
