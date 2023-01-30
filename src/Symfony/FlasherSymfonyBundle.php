<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Symfony\Container\SymfonyContainer;
use Flasher\Symfony\DependencyInjection\Compiler\EventSubscriberCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\FactoryCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\FlasherAwareCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\PresenterCompilerPass;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\Support\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherSymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        FlasherContainer::init(new SymfonyContainer($this->container));
    }

    /**
     * {@inheritDoc}
     */
    public function createPlugin()
    {
        return new FlasherPlugin();
    }

    /**
     * {@inheritdoc}
     */
    protected function flasherBuild(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FactoryCompilerPass());
        $container->addCompilerPass(new EventSubscriberCompilerPass());
        $container->addCompilerPass(new PresenterCompilerPass());
        $container->addCompilerPass(new FlasherAwareCompilerPass());
    }

    /**
     * {@inheritdoc}
     */
    protected function getFlasherContainerExtension()
    {
        return new FlasherExtension();
    }
}
