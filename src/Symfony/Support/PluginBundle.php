<?php

declare(strict_types=1);

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\FlasherSymfonyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * PluginBundle - Base class for PHPFlasher plugin bundles.
 *
 * This abstract class provides common functionality for all PHPFlasher plugin bundles.
 * It extends Symfony's AbstractBundle to integrate with the kernel bundle system,
 * while implementing PluginBundleInterface to provide PHPFlasher-specific functionality.
 *
 * Design patterns:
 * - Template Method: Defines skeleton of common bundle operations
 * - Factory Method: Creates plugin instances
 * - Bridge: Connects Symfony bundle system with PHPFlasher plugin system
 * - Extension: Extends AbstractBundle with PHPFlasher-specific functionality
 */
abstract class PluginBundle extends AbstractBundle implements PluginBundleInterface
{
    /**
     * Creates an instance of the plugin.
     *
     * This factory method must be implemented by child classes to instantiate
     * the specific plugin that the bundle integrates.
     *
     * @return PluginInterface The plugin instance
     */
    abstract public function createPlugin(): PluginInterface;

    /**
     * Loads bundle configuration into the Symfony container.
     *
     * This method registers the plugin's factory service in the container and
     * configures it appropriately. The core FlasherSymfonyBundle is exempt from
     * this process since it has special handling.
     *
     * @param array<string, mixed>  $config    The processed bundle configuration
     * @param ContainerConfigurator $container The container configurator
     * @param ContainerBuilder      $builder   The container builder
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if ($this instanceof FlasherSymfonyBundle) {
            return;
        }

        $plugin = $this->createPlugin();
        $identifier = $plugin->getServiceId();

        $container->services()
            ->set($identifier, $plugin->getFactory())
            ->parent('flasher.notification_factory')
            ->tag('flasher.factory', ['alias' => $plugin->getAlias()])
            ->public()
        ;

        foreach ((array) $plugin->getServiceAliases() as $alias) {
            $builder->setAlias($alias, $identifier);
        }
    }

    /**
     * Prepends default plugin configuration for Flasher.
     *
     * This method adds the plugin's scripts, styles, and options to the Flasher
     * configuration before the container is compiled.
     *
     * @param ContainerConfigurator $container The container configurator
     * @param ContainerBuilder      $builder   The container builder
     */
    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if ($this instanceof FlasherSymfonyBundle) {
            return;
        }

        $plugin = $this->createPlugin();

        $builder->prependExtensionConfig('flasher', [
            'plugins' => [
                $plugin->getAlias() => [
                    'scripts' => (array) $plugin->getScripts(),
                    'styles' => (array) $plugin->getStyles(),
                    'options' => $plugin->getOptions(),
                ],
            ],
        ]);
    }

    /**
     * Gets the path to the plugin's configuration file.
     *
     * Returns the absolute path to the plugin's configuration file
     * based on the bundle's path.
     *
     * @return string Absolute path to the configuration file
     */
    public function getConfigurationFile(): string
    {
        return rtrim($this->getPath(), '/').'/Resources/config/config.yaml';
    }

    /**
     * Gets the bundle's directory path.
     *
     * Uses reflection to determine the location of the bundle class file,
     * then returns its directory.
     *
     * @return string The bundle directory path
     */
    public function getPath(): string
    {
        if (!isset($this->path)) {
            $reflected = new \ReflectionObject($this);
            // assume the modern directory structure by default
            $this->path = \dirname($reflected->getFileName() ?: '');
        }

        return $this->path;
    }
}
