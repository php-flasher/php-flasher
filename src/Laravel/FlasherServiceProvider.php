<?php

namespace Flasher\Laravel;

use Flasher\Laravel\ServiceProvider\ServiceProviderManager;
use Illuminate\Support\ServiceProvider;

final class FlasherServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $manager = new ServiceProviderManager($this);
        $manager->boot();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $manager = new ServiceProviderManager($this);
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
     * @return \Illuminate\Container\Container
     */
    public function getApplication()
    {
        return $this->app;
    }

    public function mergeConfigFrom($path, $key)
    {
        parent::mergeConfigFrom($path, $key);
    }

    public function publishes(array $paths, $groups = null)
    {
        parent::publishes($paths, $groups);
    }

    public function loadTranslationsFrom($path, $namespace)
    {
        parent::loadTranslationsFrom($path, $namespace);
    }

    public function loadViewsFrom($path, $namespace)
    {
        parent::loadViewsFrom($path, $namespace);
    }
}
