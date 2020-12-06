<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\Middleware\FlasherBus;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class MiddlewareCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.flasher_bus')) {
            return;
        }

        /** @var FlasherBus $flasherBus */
        $flasherBus = $container->findDefinition('flasher.flasher_bus');

        foreach ($container->findTaggedServiceIds('flasher.middleware') as $id => $tags) {
            $flasherBus->addMethodCall('addMiddleware', array(new Reference($id)));
        }
    }
}
