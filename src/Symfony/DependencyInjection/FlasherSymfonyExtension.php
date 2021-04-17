<?php

namespace Flasher\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherSymfonyExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('config.yaml');

        $configration = $this->processConfiguration(new Configuration(), $configs);

        $config = $container->getDefinition('flasher.config');
        $config->replaceArgument(0, $configration);

        $responseManager = $container->getDefinition('flasher.resource_manager');
        foreach ($configration['template_factory']['templates'] as $template => $factory) {
            if (isset($factory['scripts'])) {
                $responseManager->addMethodCall('addScripts', array('template_'.$template, $factory['scripts']));
            }
            if (isset($factory['styles'])) {
                $responseManager->addMethodCall('addStyles', array('template_'.$template, $factory['styles']));
            }
            if (isset($factory['options'])) {
                $responseManager->addMethodCall('addOptions', array('template_'.$template, $factory['options']));
            }
        }
    }
}
