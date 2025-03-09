<?php

declare(strict_types=1);

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;

/**
 * FlasherNotySymfonyBundle - Symfony bundle for Noty integration.
 *
 * This bundle registers the Noty plugin with Symfony's service container.
 * It extends the base plugin bundle to inherit common registration logic
 * while providing the Noty-specific plugin implementation.
 *
 * Design patterns:
 * - Bundle: Implements Symfony's bundle pattern for packaging functionality
 * - Factory Method: Creates the plugin instance
 */
final class FlasherNotySymfonyBundle extends PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * Creates the Noty plugin instance.
     *
     * @return PluginInterface The Noty plugin instance
     */
    public function createPlugin(): PluginInterface
    {
        return new NotyPlugin();
    }
}
