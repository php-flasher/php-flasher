<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * EventListenerCompilerPass - Registers event listeners with the event dispatcher.
 *
 * This compiler pass finds all services tagged with 'flasher.event_listener'
 * and registers them with the PHPFlasher event dispatcher. This allows for
 * automatic discovery and registration of event listeners.
 *
 * Design patterns:
 * - Compiler Pass: Modifies container definitions during compilation
 * - Service Discovery: Automatically discovers tagged services
 * - Observer Pattern: Helps set up the event dispatch/observer system
 */
final class EventListenerCompilerPass implements CompilerPassInterface
{
    /**
     * Process the container to register event listeners.
     *
     * @param ContainerBuilder $container The service container builder
     */
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition('flasher.event_dispatcher');

        foreach (array_keys($container->findTaggedServiceIds('flasher.event_listener')) as $id) {
            $definition->addMethodCall('addListener', [new Reference($id)]);
        }
    }
}
