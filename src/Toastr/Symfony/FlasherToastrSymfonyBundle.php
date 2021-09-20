<?php

namespace Flasher\Toastr\Symfony;

use Flasher\Symfony\DependencyInjection\Compiler\ResourceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Toastr\Symfony\DependencyInjection\FlasherToastrExtension;

class FlasherToastrSymfonyBundle extends FlasherBundle
{
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ResourceCompilerPass($this->getFlasherContainerExtension()));
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherToastrExtension();
    }
}
