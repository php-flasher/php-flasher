<?php

declare(strict_types=1);

namespace Flasher\Noty\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Noty\Prime\NotyPlugin;

/**
 * FlasherNotyServiceProvider - Laravel service provider for Noty integration.
 *
 * This service provider registers the Noty plugin with Laravel's service container.
 * It extends the base plugin service provider to inherit common registration logic
 * while providing the Noty-specific plugin implementation.
 *
 * Design patterns:
 * - Service Provider: Implements Laravel's service provider pattern
 * - Factory Method: Creates the plugin instance
 */
final class FlasherNotyServiceProvider extends PluginServiceProvider
{
    /**
     * Creates the Noty plugin instance.
     *
     * @return NotyPlugin The Noty plugin instance
     */
    public function createPlugin(): NotyPlugin
    {
        return new NotyPlugin();
    }
}
