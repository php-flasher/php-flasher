<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\Renderer\RendererManager;
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
        if (!$container->has('flasher.renderer_manager')) {
            return;
        }

        /** @var RendererManager $manager */
        $manager = $container->findDefinition('flasher.renderer_manager');

        foreach ($container->findTaggedServiceIds('flasher.renderer') as $id => $tags) {
            $manager->addMethodCall('addDriver', array(new Reference($id)));
        }
    }
}
