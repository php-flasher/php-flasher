<?php

namespace Flasher\Symfony\Bridge\Typed;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class FlasherBundle extends Bundle
{
    /**
     * @return void
     */
    public function build(ContainerBuilder $container)
    {
        $this->flasherBuild($container);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return $this->getFlasherContainerExtension();
    }

    /**
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function flasherBuild(ContainerBuilder $container)
    {
    }

    /**
     * @return ?ExtensionInterface
     */
    abstract protected function getFlasherContainerExtension();
}
