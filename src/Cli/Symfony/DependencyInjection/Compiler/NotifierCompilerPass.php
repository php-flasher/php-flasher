<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class NotifierCompilerPass implements CompilerPassInterface
{
    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.cli_notifier')) {
            return;
        }

        $notifier = $container->findDefinition('flasher.cli_notifier');

        foreach ($container->findTaggedServiceIds('flasher.cli_notifier') as $id => $tags) {
            $notifier->addMethodCall('addNotifier', array(new Reference($id)));
        }
    }
}
