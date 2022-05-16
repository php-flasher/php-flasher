<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Symfony;

use Flasher\Cli\Symfony\DependencyInjection\Compiler\NotifierCompilerPass;
use Flasher\Cli\Symfony\DependencyInjection\FlasherCliExtension;
use Flasher\Symfony\Bridge\FlasherBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherCliSymfonyBundle extends FlasherBundle // Symfony\Component\HttpKernel\Bundle\Bundle
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
