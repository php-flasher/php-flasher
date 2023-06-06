<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class PresenterCompilerPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.response_manager')) {
            return;
        }

        $definition = $container->findDefinition('flasher.response_manager');

        foreach ($container->findTaggedServiceIds('flasher.presenter') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addPresenter', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
