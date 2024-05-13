<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\SweetAlert\Prime\SweetAlertPlugin;

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

        $this->app->extend('flasher.event_dispatcher', static function (EventDispatcherInterface $dispatcher) {
            $dispatcher->addListener(new LivewireListener());

            return $dispatcher;
        });
    }
}
