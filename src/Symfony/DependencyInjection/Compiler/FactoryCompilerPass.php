<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class FactoryCompilerPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher')) {
            return;
        }

        $definition = $container->findDefinition('flasher');

        foreach ($container->findTaggedServiceIds('flasher.factory') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addFactory', array($attributes['alias'], new Reference($id)));
            }
        }
    }
}
