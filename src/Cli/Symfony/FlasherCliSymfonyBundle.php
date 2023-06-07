<?php

declare(strict_types=1);

namespace Flasher\Cli\Symfony;

use Flasher\Cli\Symfony\DependencyInjection\Compiler\NotifierCompilerPass;
use Flasher\Cli\Symfony\DependencyInjection\FlasherCliExtension;
use Flasher\Symfony\Bridge\FlasherBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class FlasherCliSymfonyBundle extends FlasherBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function flasherBuild(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new NotifierCompilerPass());
    }

    protected function getFlasherContainerExtension(): FlasherCliExtension
    {
        return new FlasherCliExtension();
    }
}
