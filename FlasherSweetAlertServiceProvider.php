<?php

namespace Flasher\SweetAlert\Laravel;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Flasher\SweetAlert\Laravel\ServiceProvider\ServiceProviderManager;

final class FlasherSweetAlertServiceProvider extends ServiceProvider
{
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
            'flasher.factory.sweet_alert',
            'flasher.renderer.sweet_alert',
        );
    }

    /**
     * @return Container
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
}
