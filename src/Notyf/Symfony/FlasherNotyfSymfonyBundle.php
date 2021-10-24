<?php

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Symfony\DependencyInjection\FlasherNotyfExtension;
use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Symfony\DependencyInjection\Compiler\ResourceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherNotyfSymfonyBundle extends FlasherBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ResourceCompilerPass($this->getFlasherContainerExtension()));
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherNotyfExtension();
    }
}
