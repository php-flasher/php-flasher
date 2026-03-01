<?php

declare(strict_types=1);

namespace Flasher\Notyf\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;

final class FlasherNotyfServiceProvider extends PluginServiceProvider
{
    public function createPlugin(): NotyfPlugin
    {
        return new NotyfPlugin();
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
