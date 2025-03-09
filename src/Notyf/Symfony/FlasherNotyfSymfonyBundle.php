<?php

declare(strict_types=1);

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;

/**
 * FlasherNotyfSymfonyBundle - Symfony bundle for Notyf integration.
 *
 * This bundle registers the Notyf plugin with Symfony's service container.
 * It extends the base plugin bundle to inherit common registration logic
 * while providing the Notyf-specific plugin implementation.
 *
 * Design patterns:
 * - Bundle: Implements Symfony's bundle pattern for packaging functionality
 * - Factory Method: Creates the plugin instance
 */
final class FlasherNotyfSymfonyBundle extends PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * Creates the Notyf plugin instance.
     *
     * @return PluginInterface The Notyf plugin instance
     */
    public function createPlugin(): PluginInterface
    {
        return new NotyfPlugin();
    }
}
