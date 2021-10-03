<?php

namespace Flasher\Cli\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class NotifierCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.presenter.cli')) {
            return;
        }

        $presenter = $container->findDefinition('flasher.presenter.cli');

        foreach ($container->findTaggedServiceIds('flasher.cli_notifier') as $id => $tags) {
            $presenter->addMethodCall('addNotifier', array(new Reference($id)));
        }
    }
}
