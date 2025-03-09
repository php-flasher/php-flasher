<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\SweetAlert\Prime\SweetAlertPlugin;

/**
 * FlasherSweetAlertServiceProvider - Laravel service provider for SweetAlert2 integration.
 *
 * This service provider registers the SweetAlert2 plugin with Laravel's service container
 * and sets up the Livewire integration for interactive dialogs. It extends the base plugin
 * service provider to inherit common registration logic while providing SweetAlert-specific
 * plugin implementation and event listeners.
 *
 * Design patterns:
 * - Service Provider: Implements Laravel's service provider pattern
 * - Factory Method: Creates the plugin instance
 * - Observer: Registers event listeners for framework integration
 */
final class FlasherSweetAlertServiceProvider extends PluginServiceProvider
{
    /**
     * Creates the SweetAlert plugin instance.
     *
     * @return SweetAlertPlugin The SweetAlert plugin instance
     */
    public function createPlugin(): SweetAlertPlugin
    {
        return new SweetAlertPlugin();
    }

    /**
     * Performs additional setup after the service provider is booted.
     *
     * This method is called after all service providers have been registered.
     * It's used here to set up the Livewire integration for interactive dialogs.
     */
    protected function afterBoot(): void
    {
        $this->registerLivewireListener();
    }

    /**
     * Registers the Livewire event listener for SweetAlert dialogs.
     *
     * This listener enables SweetAlert's interactive dialogs to work with
     * Livewire's AJAX-based component updates.
     */
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
