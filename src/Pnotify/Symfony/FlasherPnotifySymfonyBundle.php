<?php

namespace Flasher\Pnotify\Symfony;

use Flasher\Pnotify\Symfony\DependencyInjection\FlasherPnotifyExtension;
use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Symfony\DependencyInjection\Compiler\ResourceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherPnotifySymfonyBundle extends FlasherBundle
{
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ResourceCompilerPass($this->getFlasherContainerExtension()));
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherPnotifyExtension();
    }
}
