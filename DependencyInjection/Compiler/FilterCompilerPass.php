<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class FilterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('notify.filter')) {
            return;
        }

        /** @var \Flasher\Prime\Filter\FilterManager $manager */
        $manager = $container->findDefinition('notify.filter');

        foreach ($container->findTaggedServiceIds('notify.filter') as $id => $tags) {
            foreach ($tags as $attributes) {
                $manager->addMethodCall('addDriver', array(
                    $attributes['alias'],
                    new Reference($id),
                ));
            }
        }
    }
}
