<?php

namespace Flasher\SweetAlert\Laravel;

use Flasher\SweetAlert\Laravel\ServiceProvider\ServiceProviderManager;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

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
            'flasher.sweet_alert',
        );
    }

    /**
     * @return Container
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
}
