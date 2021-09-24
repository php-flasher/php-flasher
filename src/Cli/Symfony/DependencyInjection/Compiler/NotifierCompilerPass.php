<?php

namespace Flasher\Cli\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\Flasher;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class NotifierCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // if (!$container->has('flasher.console')) {
        //     return;
        // }
        //
        // /** @var Flasher $manager */
        // $manager = $container->findDefinition('flasher.console');
        //
        // foreach ($container->findTaggedServiceIds('flasher.console_notifier') as $id => $tags) {
        //     $manager->addMethodCall('addNotifier', array(new Reference($id)));
        // }
    }
}
