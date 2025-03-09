<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Symfony;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Flasher\Symfony\Support\PluginBundle;

/**
 * FlasherSweetAlertSymfonyBundle - Symfony bundle for SweetAlert2 integration.
 *
 * This bundle registers the SweetAlert2 plugin with Symfony's service container.
 * It extends the base plugin bundle to inherit common registration logic
 * while providing the SweetAlert-specific plugin implementation.
 *
 * Design patterns:
 * - Bundle: Implements Symfony's bundle pattern for packaging functionality
 * - Factory Method: Creates the plugin instance
 */
final class FlasherSweetAlertSymfonyBundle extends PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * Creates the SweetAlert plugin instance.
     *
     * @return PluginInterface The SweetAlert plugin instance
     */
    public function createPlugin(): PluginInterface
    {
        return new SweetAlertPlugin();
    }
}
