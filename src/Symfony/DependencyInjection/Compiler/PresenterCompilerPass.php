<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\Renderer\PresenterManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class PresenterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('flasher.presenter_manager')) {
            return;
        }

        /** @var PresenterManager $manager */
        $manager = $container->findDefinition('flasher.presenter_manager');

        foreach ($container->findTaggedServiceIds('flasher.presenter') as $id => $tags) {
            $manager->addMethodCall('addDriver', array(new Reference($id)));
        }
    }
}
