<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Plugin\Plugin;

/**
 * NotyPlugin - Plugin definition for Noty.js integration with PHPFlasher.
 *
 * This class defines the core plugin configuration for the Noty.js notification
 * library integration. It specifies the required JavaScript and CSS assets,
 * factory class, and service identifiers for dependency injection containers.
 *
 * Design patterns:
 * - Plugin: Implements the plugin pattern for extending core functionality
 * - Registry: Registers the plugin's assets and identifiers with the core system
 * - Metadata: Provides metadata about the plugin's requirements
 */
final class NotyPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     *
     * Returns the plugin's unique identifier.
     */
    public function getAlias(): string
    {
        return 'noty';
    }

    /**
     * {@inheritdoc}
     *
     * Returns the factory class responsible for creating Noty notifications.
     */
    public function getFactory(): string
    {
        return Noty::class;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the service alias for dependency injection containers.
     */
    public function getServiceAliases(): string
    {
        return NotyInterface::class;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the required JavaScript files for Noty.js integration.
     *
     * @return string[] Array of script paths
     */
    public function getScripts(): array
    {
        return [
            '/vendor/flasher/noty.min.js',
            '/vendor/flasher/flasher-noty.min.js',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * Returns the required CSS files for Noty.js styling.
     *
     * @return string[] Array of stylesheet paths
     */
    public function getStyles(): array
    {
        return [
            '/vendor/flasher/noty.css',
            '/vendor/flasher/mint.css',
        ];
    }
}
