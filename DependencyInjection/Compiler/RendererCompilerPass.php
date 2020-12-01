<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RendererCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('notify.renderer')) {
            return;
        }

        /** @var \Flasher\Prime\Renderer\RendererManager $manager */
        $manager = $container->findDefinition('notify.renderer');

        foreach ($container->findTaggedServiceIds('notify.renderer') as $id => $tags) {
            foreach ($tags as $attributes) {
                $manager->addMethodCall('addDriver', array(
                    $attributes['alias'],
                    new Reference($id),
                ));
            }
        }
    }
}
