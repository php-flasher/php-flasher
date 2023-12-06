<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class EventListenerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition('flasher.event_dispatcher');

        foreach (array_keys($container->findTaggedServiceIds('flasher.event_listener')) as $id) {
            $definition->addMethodCall('addListener', [new Reference($id)]);
        }
    }
}
