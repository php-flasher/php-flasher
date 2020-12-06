<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\Filter\FilterManager;
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
        if (!$container->has('flasher.filter_manager')) {
            return;
        }

        /** @var FilterManager $manager */
        $manager = $container->findDefinition('flasher.filter_manager');

        foreach ($container->findTaggedServiceIds('flasher.filter') as $id => $tags) {
            $manager->addMethodCall('addDriver', array(new Reference($id)));
        }
    }
}
