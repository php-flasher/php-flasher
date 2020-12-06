<?php

namespace Flasher\Symfony;

use Flasher\Symfony\DependencyInjection\Compiler\EventSubscriberCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\FilterCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\FactoryCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\MiddlewareCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\RendererCompilerPass;
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
        $container->addCompilerPass(new RendererCompilerPass());
        $container->addCompilerPass(new FilterCompilerPass());
        $container->addCompilerPass(new MiddlewareCompilerPass());
        $container->addCompilerPass(new EventSubscriberCompilerPass());
    }
}
