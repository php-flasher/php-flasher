<?php

namespace Flasher\Console\Symfony;

use Flasher\Console\Symfony\DependencyInjection\Compiler\NotifierCompilerPass;
use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Console\Symfony\DependencyInjection\FlasherConsoleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherConsoleSymfonyBundle extends FlasherBundle
{
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new NotifierCompilerPass());
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherConsoleExtension();
    }
}
