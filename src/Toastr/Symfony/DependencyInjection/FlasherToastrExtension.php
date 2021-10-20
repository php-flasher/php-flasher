<?php

namespace Flasher\Toastr\Symfony\DependencyInjection;

use Flasher\Symfony\DependencyInjection\FlasherExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherToastrExtension extends Extension implements FlasherExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');
    }

    public function getConfigurationClass()
    {
        return new Configuration();
    }
}
