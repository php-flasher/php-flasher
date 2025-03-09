<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Plugin\Plugin;

/**
 * ToastrPlugin - Plugin definition for Toastr.js integration with PHPFlasher.
 *
 * This class defines the core plugin configuration for the Toastr.js notification
 * library integration. It specifies the required JavaScript and CSS assets,
 * factory class, and service identifiers for dependency injection containers.
 *
 * Toastr.js is a JavaScript library for non-blocking notifications with
 * simple API and highly customizable UI.
 *
 * Design patterns:
 * - Plugin: Implements the plugin pattern for extending core functionality
 * - Registry: Registers the plugin's assets and identifiers with the core system
 * - Metadata: Provides metadata about the plugin's requirements
 */
final class ToastrPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     *
     * Returns the plugin's unique identifier.
     *
     * @return string The plugin alias ('toastr')
     */
    public function getAlias(): string
    {
        return 'toastr';
    }

    /**
     * {@inheritdoc}
     *
     * Returns the factory class responsible for creating Toastr notifications.
     *
     * @return string The factory class name
     */
    public function getFactory(): string
    {
        return Toastr::class;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the service alias for dependency injection containers.
     *
     * @return string The service interface name
     */
    public function getServiceAliases(): string
    {
        return ToastrInterface::class;
    }

    /**
     * {@inheritdoc}
     *
     * Returns the required JavaScript files for Toastr.js integration.
     *
     * Note: Toastr depends on jQuery, so jQuery is included in the scripts.
     *
     * @return string[] Array of script paths
     */
    public function getScripts(): array
    {
        return [
            '/vendor/flasher/jquery.min.js',
            '/vendor/flasher/toastr.min.js',
            '/vendor/flasher/flasher-toastr.min.js',
        ];
    }

    /**
     * {@inheritdoc}
     *
     * Returns the required CSS files for Toastr.js styling.
     *
     * @return string[] Array of stylesheet paths
     */
    public function getStyles(): array
    {
        return [
            '/vendor/flasher/toastr.min.css',
        ];
    }
}
