<?php

namespace Flasher\Symfony;

use Flasher\Symfony\DependencyInjection\Compiler\EventSubscriberCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\FactoryCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\PresenterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlasherBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FactoryCompilerPass());
        $container->addCompilerPass(new EventSubscriberCompilerPass());
        $container->addCompilerPass(new PresenterCompilerPass());
    }
}
