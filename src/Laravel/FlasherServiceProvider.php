<?php

namespace Flasher\Laravel;

use Flasher\Laravel\ServiceProvider\ServiceProviderManager;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

final class FlasherServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** @var Container $app */
        $app = $this->app;
        $manager = new ServiceProviderManager($this, $app);
        $manager->boot();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        /** @var Container $app */
        $app = $this->app;
        $manager = new ServiceProviderManager($this, $app);
        $manager->register();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return array(
            'flasher',
        );
    }

    /**
     * @return Container
     */
    public function getApplication()
    {
        /** @var Container $app */
        $app = $this->app;

        return $app;
    }

    public function mergeConfigFrom($path, $key)
    {
        parent::mergeConfigFrom($path, $key);
    }

    /**
     * @param string[] $paths
     */
    public function publishes(array $paths, $groups = null)
    {
        parent::publishes($paths, $groups);
    }

    public function loadTranslationsFrom($path, $namespace)
    {
        parent::loadTranslationsFrom($path, $namespace);
    }

    /**
     * @param string $path
     */
    public function loadViewsFrom($path, $namespace)
    {
        parent::loadViewsFrom($path, $namespace);
    }
}
