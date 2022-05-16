<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
final class EventSubscriberCompilerPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.event_dispatcher')) {
            return;
        }

        $definition = $container->findDefinition('flasher.event_dispatcher');

        foreach ($container->findTaggedServiceIds('flasher.event_subscriber') as $id => $tags) {
            $definition->addMethodCall('addSubscriber', array(new Reference($id)));
        }
    }
}
