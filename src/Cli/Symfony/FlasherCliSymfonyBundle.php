<?php

namespace Flasher\Cli\Symfony;

use Flasher\Cli\Symfony\DependencyInjection\Compiler\NotifierCompilerPass;
use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Cli\Symfony\DependencyInjection\FlasherCliExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherCliSymfonyBundle extends FlasherBundle
{
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new NotifierCompilerPass());
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherCliExtension();
    }
}
