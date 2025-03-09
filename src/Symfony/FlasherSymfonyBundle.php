<?php

declare(strict_types=1);

namespace Flasher\Symfony;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Symfony\DependencyInjection\Compiler\EventListenerCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\PresenterCompilerPass;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * FlasherSymfonyBundle - Main bundle for PHPFlasher Symfony integration.
 *
 * This bundle serves as the entry point for integrating PHPFlasher with Symfony.
 * It registers compiler passes, configures the container extension, and sets up
 * the global container instance for PHPFlasher.
 *
 * Design patterns:
 * - Bundle: Implements Symfony's bundle pattern for packaging functionality
 * - Registry: Sets up the container registry for PHPFlasher
 * - Extension: Extends the base plugin bundle with PHPFlasher-specific functionality
 */
final class FlasherSymfonyBundle extends Support\PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * Set up the global container reference when the bundle boots.
     *
     * This allows PHPFlasher to access services from Symfony's container.
     */
    public function boot(): void
    {
        if ($this->container instanceof ContainerInterface) {
            FlasherContainer::from($this->container);
        }
    }

    /**
     * Register compiler passes with the container.
     *
     * @param ContainerBuilder $container The container builder
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new EventListenerCompilerPass());
        $container->addCompilerPass(new PresenterCompilerPass());
    }

    /**
     * Get the container extension for this bundle.
     *
     * @return ExtensionInterface The bundle extension
     */
    public function getContainerExtension(): ExtensionInterface
    {
        return new FlasherExtension($this->createPlugin());
    }

    /**
     * Create the core PHPFlasher plugin.
     *
     * @return FlasherPlugin The core PHPFlasher plugin
     */
    public function createPlugin(): FlasherPlugin
    {
        return new FlasherPlugin();
    }
}
