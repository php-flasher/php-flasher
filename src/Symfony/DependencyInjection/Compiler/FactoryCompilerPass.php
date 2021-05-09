<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\Flasher;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class FactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher')) {
            return;
        }

        /** @var Flasher $manager */
        $manager = $container->findDefinition('flasher');

        foreach ($container->findTaggedServiceIds('flasher.factory') as $id => $tags) {
            foreach ($tags as $attributes) {
                $manager->addMethodCall('addFactory', array($attributes['alias'], new Reference($id)));
            }
        }
    }
}
