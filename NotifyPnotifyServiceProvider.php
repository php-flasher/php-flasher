<?php

namespace Flasher\Pnotify\Laravel;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Flasher\Pnotify\Laravel\ServiceProvider\ServiceProviderManager;

class NotifyPnotifyServiceProvider extends ServiceProvider
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
            'notify.producer',
            'notify.producer.pnotify',
            'notify.renderer.pnotify',
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
}
