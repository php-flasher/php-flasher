<?php

namespace Flasher\SweetAlert\Symfony;

use Flasher\SweetAlert\Symfony\DependencyInjection\FlasherSweetAlertExtension;
use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Symfony\DependencyInjection\Compiler\ResourceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherSweetAlertSymfonyBundle extends FlasherBundle
{
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ResourceCompilerPass($this->getFlasherContainerExtension()));
    }

    protected function getFlasherContainerExtension()
    {
        return new FlasherSweetAlertExtension();
    }
}
