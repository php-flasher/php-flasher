<?php

namespace Flasher\Symfony;

use Flasher\Symfony\DependencyInjection\Compiler\FilterCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\ProducerCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\RendererCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NotifyBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ProducerCompilerPass());
        $container->addCompilerPass(new RendererCompilerPass());
        $container->addCompilerPass(new FilterCompilerPass());
    }
}
