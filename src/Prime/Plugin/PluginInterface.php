<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Factory\NotificationFactoryInterface;

/**
 * PluginInterface - Contract for PHPFlasher plugins.
 *
 * This interface defines the essential operations for PHPFlasher plugins.
 * A plugin typically provides a notification renderer implementation along with
 * its associated assets (scripts, styles) and configuration. The interface
 * ensures that plugins can be discovered and loaded in a consistent way.
 *
 * Design patterns:
 * - Plugin: Defines an extension mechanism for the core system
 * - Strategy: Allows plugging in different notification display strategies
 */
interface PluginInterface
{
    /**
     * Gets the plugin's short name/alias.
     *
     * This is used in configuration and as part of service IDs.
     *
     * @return string The plugin alias (e.g., 'toastr', 'sweetalert')
     */
    public function getAlias(): string;

    /**
     * Gets the plugin's full name.
     *
     * This can be used for display purposes in UIs.
     *
     * @return string The plugin name
     */
    public function getName(): string;

    /**
     * Gets the plugin's primary service ID.
     *
     * This is the ID that will be used to register the plugin's factory
     * in the service container.
     *
     * @return string The service ID (e.g., 'flasher.toastr')
     */
    public function getServiceId(): string;

    /**
     * Gets the plugin's factory class.
     *
     * This is the class that will be instantiated to create notifications
     * for this plugin.
     *
     * @return class-string<NotificationFactoryInterface> The factory class name
     */
    public function getFactory(): string;

    /**
     * Gets the service aliases for the plugin.
     *
     * These are alternative service IDs or interfaces that the plugin's
     * factory will be registered under.
     *
     * @return string|string[] The service alias(es)
     */
    public function getServiceAliases(): string|array;

    /**
     * Gets the JavaScript files needed by the plugin.
     *
     * These scripts will be included in the page when notifications
     * from this plugin are displayed.
     *
     * @return string|string[] The script file path(s)
     */
    public function getScripts(): string|array;

    /**
     * Gets the CSS stylesheets needed by the plugin.
     *
     * These styles will be included in the page when notifications
     * from this plugin are displayed.
     *
     * @return string|string[] The stylesheet file path(s)
     */
    public function getStyles(): string|array;

    /**
     * Gets the default configuration options for the plugin.
     *
     * These options control the appearance and behavior of notifications
     * created by this plugin.
     *
     * @return array<string, mixed> The default options
     */
    public function getOptions(): array;

    /**
     * Gets the directory containing the plugin's assets.
     *
     * This directory contains the public files (JS, CSS, images) used by the plugin.
     *
     * @return string The absolute path to the assets directory
     */
    public function getAssetsDir(): string;

    /**
     * Gets the directory containing the plugin's resources.
     *
     * This directory contains templates, configurations, and other non-public files.
     *
     * @return string The absolute path to the resources directory
     */
    public function getResourcesDir(): string;

    /**
     * Normalizes the plugin configuration.
     *
     * This method takes a raw configuration array and transforms it into a
     * standardized format with all required keys and proper value types.
     *
     * @param array{
     *     scripts?: string|string[],
     *     styles?: string|string[],
     *     options?: array<string, mixed>,
     * } $config The raw configuration
     *
     * @return array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     * } The normalized configuration
     */
    public function normalizeConfig(array $config): array;
}
