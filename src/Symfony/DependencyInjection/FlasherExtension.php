<?php

namespace Flasher\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('config.php');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->registerFlasherConfigration($config, $container);
        $this->registerResourceManagerConfiguration($config, $container);
        $this->registerSessionConfiguration($config, $container);
    }

    public function registerFlasherConfigration(array $config, ContainerBuilder $container)
    {
        $configuration = $container->getDefinition('flasher.config');
        $configuration->replaceArgument(0, $config);
    }

    public function registerResourceManagerConfiguration(array $config, ContainerBuilder $container)
    {
        $responseManager = $container->getDefinition('flasher.resource_manager');
        foreach ($config['template_factory']['templates'] as $template => $factory) {
            if (isset($factory['scripts'])) {
                $responseManager->addMethodCall('addScripts', array('template_' . $template, $factory['scripts']));
            }
            if (isset($factory['styles'])) {
                $responseManager->addMethodCall('addStyles', array('template_' . $template, $factory['styles']));
            }
            if (isset($factory['options'])) {
                $responseManager->addMethodCall('addOptions', array('template_' . $template, $factory['options']));
            }
        }
    }

    public function registerSessionConfiguration(array $config, ContainerBuilder $container)
    {
        $storageFactory = $container->getDefinition('flasher.storage_factory');

        if ($container->has('request_stack')) {
            $storageFactory->replaceArgument(0, $container->getDefinition('request_stack'));

            return;
        }

        if ($container->has('session')) {
            $storageFactory->replaceArgument(0, $container->getDefinition('session'));

            return;
        }
    }
}
