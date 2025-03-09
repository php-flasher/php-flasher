<?php

declare(strict_types=1);

namespace Flasher\Notyf\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Notyf\Prime\NotyfPlugin;

/**
 * FlasherNotyfServiceProvider - Laravel service provider for Notyf integration.
 *
 * This service provider registers the Notyf plugin with Laravel's service container.
 * It extends the base plugin service provider to inherit common registration logic
 * while providing the Notyf-specific plugin implementation.
 *
 * Design patterns:
 * - Service Provider: Implements Laravel's service provider pattern
 * - Factory Method: Creates the plugin instance
 */
final class FlasherNotyfServiceProvider extends PluginServiceProvider
{
    /**
     * Creates the Notyf plugin instance.
     *
     * @return NotyfPlugin The Notyf plugin instance
     */
    public function createPlugin(): NotyfPlugin
    {
        return new NotyfPlugin();
    }
}
