<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Prime\Flasher;
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
        if (!$container->has('flasher.response_manager')) {
            return;
        }

        /** @var Flasher $manager */
        $manager = $container->findDefinition('flasher.response_manager');

        foreach ($container->findTaggedServiceIds('flasher.presenter') as $id => $tags) {
            foreach ($tags as $attributes) {
                $manager->addMethodCall('addPresenter', array($attributes['alias'], new Reference($id)));
            }
        }
    }
}
