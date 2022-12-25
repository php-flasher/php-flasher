<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class FlasherAwareCompilerPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher')) {
            return;
        }

        $flasher = $container->findDefinition('flasher');

        foreach ($container->findTaggedServiceIds('flasher.flasher_aware') as $id => $tags) {
            $service = $container->findDefinition($id);
            $service->addMethodCall('setFlasher', array($flasher));
        }
    }
}
