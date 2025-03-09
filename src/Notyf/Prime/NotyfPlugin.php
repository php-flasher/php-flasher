<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Plugin\Plugin;

/**
 * NotyfPlugin - Plugin definition for Notyf.js integration with PHPFlasher.
 *
 * This class defines the core plugin configuration for the Notyf.js notification
 * library integration. It specifies the required JavaScript and CSS assets,
 * factory class, and service identifiers for dependency injection containers.
 *
 * Design patterns:
 * - Plugin: Implements the plugin pattern for extending core functionality
 * - Registry: Registers the plugin's assets and identifiers with the core system
 * - Metadata: Provides metadata about the plugin's requirements
 */
final class NotyfPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     *
     * Returns the plugin's unique identifier.
     */
    public function getAlias(): string
    {
        return 'notyf';
    }

    /**
     * {@inheritdoc}
     *
     * Returns the factory class responsible for creating Notyf notifications.
     */
    public function getFactory(): string
    {
        return Notyf::class;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the service alias for dependency injection containers.
     */
    public function getServiceAliases(): string
    {
        return NotyfInterface::class;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the required JavaScript files for Notyf.js integration.
     * Compared to other libraries, Notyf has a minimal footprint with just one script.
     *
     * @return string[] Array of script paths
     */
    public function getScripts(): array
    {
        return [
            '/vendor/flasher/flasher-notyf.min.js',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * Returns the required CSS files for Notyf.js styling.
     * Notyf has a minimal footprint with just one stylesheet.
     *
     * @return string[] Array of stylesheet paths
     */
    public function getStyles(): array
    {
        return [
            '/vendor/flasher/flasher-notyf.min.css',
        ];
    }
}
