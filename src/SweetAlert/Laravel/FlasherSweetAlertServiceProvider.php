<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\SweetAlert\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Livewire\LivewireManager;

final class FlasherSweetAlertServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    protected function createPlugin()
    {
        return new SweetAlertPlugin();
    }

    /**
     * {@inheritDoc}
     */
    protected function afterBoot()
    {
        $this->registerLivewireListener();
    }

    /**
     * @return void
     */
    private function registerLivewireListener()
    {
        if (!$this->app->bound('livewire')) {
            return;
        }

        $livewire = $this->app->make('livewire');
        if (!$livewire instanceof LivewireManager) {
            return;
        }

        $this->app->extend('flasher.event_dispatcher', function (EventDispatcherInterface $dispatcher) {
            $dispatcher->addSubscriber(new LivewireListener());

            return $dispatcher;
        });
    }
}
