<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Livewire\LivewireManager;

final class FlasherSweetAlertServiceProvider extends PluginServiceProvider
{
    public function createPlugin(): SweetAlertPlugin
    {
        return new SweetAlertPlugin();
    }

    protected function afterBoot(): void
    {
        $this->registerLivewireListener();
    }

    private function registerLivewireListener(): void
    {
        if (!$this->app->bound('livewire')) {
            return;
        }

        $livewire = $this->app->make('livewire');
        if (!$livewire instanceof LivewireManager) {
            return;
        }

        $this->app->extend('flasher.event_dispatcher', static function (EventDispatcherInterface $dispatcher) {
            $dispatcher->addListener(new LivewireListener());

            return $dispatcher;
        });
    }
}
