<?php

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
            $notifier->addMethodCall('addNotifier', [new Reference($id)]);
        }
    }
}
