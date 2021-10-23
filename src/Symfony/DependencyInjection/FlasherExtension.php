<?php

namespace Flasher\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->registerFlasherConfiguration($config, $container);
        $this->registerTemplateFactoriesConfigurations($config, $container);
        $this->registerResourceManagerConfiguration($config, $container);
        $this->registerSessionConfiguration($container);
        $this->registerServicesForAutoConfiguration($container);
    }

    public function registerFlasherConfiguration(array $config, ContainerBuilder $container)
    {
        $configuration = $container->getDefinition('flasher.config');
        $configuration->replaceArgument(0, $config);
    }

    public function registerTemplateFactoriesConfigurations(array $config, ContainerBuilder $container)
    {
        foreach ($config['template_factory']['templates'] as $template => $options) {
            $container
                ->register('flasher.template.'.$template, 'Flasher\Prime\Factory\TemplateFactory')
                ->addArgument(new Reference('flasher.storage_manager'))
                ->addMethodCall('setHandler', array('template.'.$template))
                ->addTag('flasher.factory', array('alias' => 'template.'.$template));
        }
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

    public function registerSessionConfiguration(ContainerBuilder $container)
    {
        $storageFactory = $container->getDefinition('flasher.storage_factory');

        if ($container->has('request_stack')) {
            $storageFactory->replaceArgument(0, $container->getDefinition('request_stack'));

            return;
        }

        if ($container->has('session')) {
            $storageFactory->replaceArgument(0, $container->getDefinition('session'));
        }
    }

    public function registerServicesForAutoConfiguration(ContainerBuilder $container)
    {
        if (!method_exists($container, 'registerForAutoconfiguration')) {
            return;
        }

        $container
            ->registerForAutoconfiguration('Flasher\Prime\EventDispatcher\EventDispatcherInterface')
            ->addTag('flasher.event_subscriber')
        ;
    }
}
