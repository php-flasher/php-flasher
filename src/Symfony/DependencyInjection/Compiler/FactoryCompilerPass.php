<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\Flasher;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class FactoryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.factory_manager')) {
            return;
        }

        /** @var Flasher $manager */
        $manager = $container->findDefinition('flasher.factory_manager');

        foreach ($container->findTaggedServiceIds('flasher.factory') as $id => $tags) {
            $manager->addMethodCall('addDriver', array(new Reference($id)));
        }
    }
}
