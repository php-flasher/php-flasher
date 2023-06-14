<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class EventListenerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (! $container->has('flasher.event_dispatcher')) {
            return;
        }

        $definition = $container->findDefinition('flasher.event_dispatcher');

        foreach ($container->findTaggedServiceIds('flasher.event_listener') as $id => $tags) {
            $definition->addMethodCall('addListener', [new Reference($id)]);
        }
    }
}
