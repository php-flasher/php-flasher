<?php

declare(strict_types=1);

namespace Flasher\Toastr\Symfony;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;
use Flasher\Toastr\Prime\ToastrPlugin;

/**
 * FlasherToastrSymfonyBundle - Symfony bundle for Toastr integration.
 *
 * This bundle registers the Toastr plugin with Symfony's service container.
 * It extends the base plugin bundle to inherit common registration logic
 * while providing the Toastr-specific plugin implementation.
 *
 * Design patterns:
 * - Bundle: Implements Symfony's bundle pattern for packaging functionality
 * - Factory Method: Creates the plugin instance
 * - Extension: Extends base functionality with specific implementation
 */
final class FlasherToastrSymfonyBundle extends PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * Creates the Toastr plugin instance.
     *
     * This factory method is responsible for instantiating the specific
     * plugin implementation that will be registered with the service container.
     *
     * @return PluginInterface The Toastr plugin instance
     */
    public function createPlugin(): PluginInterface
    {
        return new ToastrPlugin();
    }
}
