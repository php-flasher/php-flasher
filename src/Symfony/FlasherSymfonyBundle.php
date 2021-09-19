<?php

namespace Flasher\Symfony;

use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Symfony\DependencyInjection\Compiler\EventSubscriberCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\FactoryCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\PresenterCompilerPass;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherSymfonyBundle extends FlasherBundle
{
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FactoryCompilerPass());
        $container->addCompilerPass(new EventSubscriberCompilerPass());
        $container->addCompilerPass(new PresenterCompilerPass());
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherExtension();
    }
}
