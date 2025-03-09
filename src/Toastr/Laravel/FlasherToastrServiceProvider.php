<?php

declare(strict_types=1);

namespace Flasher\Toastr\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Toastr\Prime\ToastrPlugin;

/**
 * FlasherToastrServiceProvider - Laravel service provider for Toastr integration.
 *
 * This service provider registers the Toastr plugin with Laravel's service container.
 * It extends the base plugin service provider to inherit common registration logic
 * while providing the Toastr-specific plugin implementation.
 *
 * Design patterns:
 * - Service Provider: Implements Laravel's service provider pattern
 * - Factory Method: Creates the plugin instance
 * - Extension: Extends base functionality with specific implementation
 */
final class FlasherToastrServiceProvider extends PluginServiceProvider
{
    /**
     * Creates the Toastr plugin instance.
     *
     * This factory method is responsible for instantiating the specific
     * plugin implementation that will be registered with the service container.
     *
     * @return ToastrPlugin The Toastr plugin instance
     */
    public function createPlugin(): ToastrPlugin
    {
        return new ToastrPlugin();
    }
}
