<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

/**
 * Plugin - Base class for PHPFlasher plugins.
 *
 * This abstract class provides a common foundation for PHPFlasher plugins,
 * implementing standard behaviors and conventions. Plugin implementations
 * should extend this class and customize the specific aspects they need to change.
 *
 * Design patterns:
 * - Template Method: Defines standard algorithms with customizable steps
 * - Convention over Configuration: Provides sensible defaults based on naming conventions
 */
abstract class Plugin implements PluginInterface
{
    /**
     * {@inheritdoc}
     *
     * By default, derives the plugin name from its alias with a "flasher_" prefix.
     */
    public function getName(): string
    {
        return 'flasher_'.$this->getAlias();
    }

    /**
     * {@inheritdoc}
     *
     * By default, derives the service ID from the plugin alias with a "flasher." prefix.
     */
    public function getServiceId(): string
    {
        return 'flasher.'.$this->getAlias();
    }

    /**
     * {@inheritdoc}
     *
     * By default, returns an empty array, meaning no service aliases are registered.
     */
    public function getServiceAliases(): string|array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     *
     * By default, returns an empty array, meaning no scripts are included.
     */
    public function getScripts(): string|array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     *
     * By default, returns an empty array, meaning no styles are included.
     */
    public function getStyles(): string|array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     *
     * By default, returns an empty array, meaning no options are configured.
     */
    public function getOptions(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     *
     * By default, locates the assets directory by convention based on the plugin's
     * class location.
     */
    public function getAssetsDir(): string
    {
        $resourcesDir = $this->getResourcesDir();
        $assetsDir = rtrim($resourcesDir, '/').'/public/';

        return realpath($assetsDir) ?: '';
    }

    /**
     * {@inheritdoc}
     *
     * By default, locates the resources directory by convention based on the plugin's
     * class location. Looks first for a Resources subdirectory in the same directory,
     * then falls back to a Resources directory one level up.
     */
    public function getResourcesDir(): string
    {
        $reflection = new \ReflectionClass($this);
        $pluginDir = pathinfo($reflection->getFileName() ?: '', \PATHINFO_DIRNAME);
        $resourcesDir = is_dir($pluginDir.'/Resources/')
            ? $pluginDir.'/Resources/'
            : $pluginDir.'/../Resources/';

        return realpath($resourcesDir) ?: '';
    }

    /**
     * {@inheritdoc}
     *
     * This implementation merges the provided config with defaults from the plugin's
     * getScripts(), getStyles(), and getOptions() methods and ensures arrays are properly
     * normalized.
     */
    public function normalizeConfig(array $config): array
    {
        $config = [
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
            ...$config,
        ];

        $config['styles'] = (array) $config['styles'];
        $config['scripts'] = (array) $config['scripts'];

        return $config;
    }
}
