<?php

declare(strict_types=1);

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;

/**
 * PluginBundleInterface - Contract for PHPFlasher plugin bundles.
 *
 * This interface defines the basic requirements for a Symfony bundle that
 * integrates a PHPFlasher plugin. It focuses on plugin creation and configuration.
 *
 * Design patterns:
 * - Factory Method: Defines interface for creating plugin instances
 * - Plugin Architecture: Supports extensible plugin system
 * - Bridge: Connects Symfony bundle system with PHPFlasher plugin system
 */
interface PluginBundleInterface
{
    /**
     * Creates an instance of the plugin.
     *
     * This factory method is responsible for instantiating the plugin that
     * this bundle integrates with Symfony.
     *
     * @return PluginInterface The plugin instance
     */
    public function createPlugin(): PluginInterface;

    /**
     * Gets the path to the plugin's configuration file.
     *
     * @return string Absolute path to the configuration file
     */
    public function getConfigurationFile(): string;
}
