<?php

namespace Flasher\Laravel;

use Illuminate\Support\ServiceProvider;
use Flasher\Laravel\ServiceProvider\ServiceProviderManager;

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
            'flasher.factory',
        );
    }

    /**
     * @return \Illuminate\Container\Container
     */
    public function getApplication()
    {
        return $this->app;
    }

    /**
     * {@inheritdoc}
     */
    public function mergeConfigFrom($path, $key)
    {
        parent::mergeConfigFrom($path, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function publishes(array $paths, $groups = null)
    {
        parent::publishes($paths, $groups);
    }

    /**
     * {@inheritdoc}
     */
    public function loadTranslationsFrom($path, $namespace)
    {
        parent::loadTranslationsFrom($path, $namespace);
    }
}
