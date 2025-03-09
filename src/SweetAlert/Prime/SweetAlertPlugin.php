<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Plugin\Plugin;

/**
 * SweetAlertPlugin - Plugin definition for SweetAlert2 integration with PHPFlasher.
 *
 * This class defines the core plugin configuration for the SweetAlert2 notification
 * library integration. It specifies the required JavaScript and CSS assets,
 * factory class, and service identifiers for dependency injection containers.
 *
 * SweetAlert2 offers rich, customizable modal dialogs beyond simple notifications,
 * including confirm dialogs, input forms, and custom content.
 *
 * Design patterns:
 * - Plugin: Implements the plugin pattern for extending core functionality
 * - Registry: Registers the plugin's assets and identifiers with the core system
 * - Metadata: Provides metadata about the plugin's requirements
 */
final class SweetAlertPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     *
     * Returns the plugin's unique identifier.
     */
    public function getAlias(): string
    {
        return 'sweetalert';
    }

    /**
     * {@inheritdoc}
     *
     * Returns the factory class responsible for creating SweetAlert notifications.
     */
    public function getFactory(): string
    {
        return SweetAlert::class;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the service alias for dependency injection containers.
     */
    public function getServiceAliases(): string
    {
        return SweetAlertInterface::class;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the required JavaScript files for SweetAlert2 integration.
     * Includes both the core SweetAlert2 library and the PHPFlasher adapter.
     *
     * @return string[] Array of script paths
     */
    public function getScripts(): array
    {
        return [
            '/vendor/flasher/sweetalert2.min.js',
            '/vendor/flasher/flasher-sweetalert.min.js',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * Returns the required CSS files for SweetAlert2 styling.
     *
     * @return string[] Array of stylesheet paths
     */
    public function getStyles(): array
    {
        return [
            '/vendor/flasher/sweetalert2.min.css',
        ];
    }
}
