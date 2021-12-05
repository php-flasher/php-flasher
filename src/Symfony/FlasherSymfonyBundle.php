<?php

namespace Flasher\Symfony;

use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Symfony\DependencyInjection\Compiler\EventSubscriberCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\FactoryCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\PresenterCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\SessionCompilerPass;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherSymfonyBundle extends FlasherBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FactoryCompilerPass());
        $container->addCompilerPass(new EventSubscriberCompilerPass());
        $container->addCompilerPass(new PresenterCompilerPass());
        $container->addCompilerPass(new SessionCompilerPass());
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherExtension();
    }
}
