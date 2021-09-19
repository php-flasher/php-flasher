<?php

namespace Flasher\Symfony\Bridge\Legacy;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class FlasherBundle extends Bundle
{
    /**
     * @return void
     */
    protected function flasherBuild(ContainerBuilder $container)
    {
    }

    /**
     * @return ?ExtensionInterface
     */
    abstract protected function getFlasherContainerExtension();

    public function build(ContainerBuilder $container)
    {
        $this->flasherBuild($container);
    }

    public function getContainerExtension()
    {
        return $this->getFlasherContainerExtension();
    }
}
