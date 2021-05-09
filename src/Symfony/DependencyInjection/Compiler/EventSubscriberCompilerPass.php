<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class EventSubscriberCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.event_dispatcher')) {
            return;
        }

        /** @var EventDispatcherInterface $flasherBus */
        $eventDispatcher = $container->findDefinition('flasher.event_dispatcher');

        foreach ($container->findTaggedServiceIds('flasher.event_subscriber') as $id => $tags) {
            $eventDispatcher->addMethodCall('addSubscriber', array(new Reference($id)));
        }
    }
}
