<?php

declare(strict_types=1);

namespace Flasher\Toastr\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrServiceProvider extends PluginServiceProvider
{
    public function createPlugin(): ToastrPlugin
    {
        return new ToastrPlugin();
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
