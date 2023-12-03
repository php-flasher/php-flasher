<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class FactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('flasher')) {
            return;
        }

        $definition = $container->findDefinition('flasher');

        foreach ($container->findTaggedServiceIds('flasher.factory') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addFactory', [
                    $attributes['alias'],
                    new ServiceClosureArgument(new Reference($id)),
                ]);
            }
        }
    }
}
