<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\Legacy;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class FlasherBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $this->flasherBuild($container);
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
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
