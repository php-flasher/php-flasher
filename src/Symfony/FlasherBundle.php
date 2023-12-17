<?php

declare(strict_types=1);

namespace Flasher\Symfony;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Symfony\DependencyInjection\Compiler\EventListenerCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\FactoryCompilerPass;
use Flasher\Symfony\DependencyInjection\Compiler\PresenterCompilerPass;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FlasherBundle extends Bundle
{
    public function boot(): void
    {
        FlasherContainer::from($this->container);
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new FactoryCompilerPass());
        $container->addCompilerPass(new EventListenerCompilerPass());
        $container->addCompilerPass(new PresenterCompilerPass());
    }

    public function getContainerExtension(): ExtensionInterface
    {
        return new FlasherExtension(new FlasherPlugin());
    }
}
