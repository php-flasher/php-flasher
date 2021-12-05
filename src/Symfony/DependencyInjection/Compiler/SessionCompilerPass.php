<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SessionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.storage')) {
            return;
        }

        $storage = $container->getDefinition('flasher.storage');

        if (null !== $storage->getArgument(0)) {
            return;
        }

        if ($container->has('request_stack')) {
            $storage->replaceArgument(0, new Reference('request_stack'));
            return;
        }

        if (null === $storage->getArgument(0) && $container->has('session')) {
            $storage->replaceArgument(0, new Reference('session'));
        }
    }
}
