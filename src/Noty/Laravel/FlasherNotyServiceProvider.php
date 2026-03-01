<?php

declare(strict_types=1);

namespace Flasher\Noty\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;

final class FlasherNotyServiceProvider extends PluginServiceProvider
{
    public function createPlugin(): NotyPlugin
    {
        return new NotyPlugin();
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
