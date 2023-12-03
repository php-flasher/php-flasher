<?php

declare(strict_types=1);

namespace Flasher\Cli\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class NotifierCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('flasher.cli_notifier')) {
            return;
        }

        $notifier = $container->findDefinition('flasher.cli_notifier');

        foreach (array_keys($container->findTaggedServiceIds('flasher.cli_notifier')) as $id) {
            $notifier->addMethodCall('addNotifier', [new Reference($id)]);
        }
    }
}
