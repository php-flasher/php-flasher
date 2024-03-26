<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class PresenterCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition('flasher.response_manager');

        foreach ($container->findTaggedServiceIds('flasher.presenter') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addPresenter', [
                    $attributes['alias'],
                    new ServiceClosureArgument(new Reference($id)),
                ]);
            }
        }
    }
}
