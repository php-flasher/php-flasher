<?php

namespace Flasher\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension as SymfonyExtension;

abstract class Extension extends SymfonyExtension implements CompilerPassInterface
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, $this->getConfigFileLocator());
        $loader->load('config.yaml');
    }

    public function process(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration($this->getConfigClass(), $configs);

        $responseManager = $container->getDefinition('flasher.resource_manager');
        $responseManager->addMethodCall('addScripts', array($this->getHandlerAlias(), $this->getScripts($config)));
        $responseManager->addMethodCall('addStyles', array($this->getHandlerAlias(), $this->getStyles($config)));
        $responseManager->addMethodCall('addOptions', array($this->getHandlerAlias(), $this->getOptions($config)));
    }

    /**
     * @return FileLocatorInterface
     */
    protected abstract function getConfigFileLocator();

    /**
     * @return ConfigurationInterface
     */
    protected abstract function getConfigClass();

    /**
     * @return string
     */
    protected function getHandlerAlias()
    {
        return str_replace('flasher_', '', $this->getAlias());
    }

    /**
     * @param array $config
     *
     * @return array
     */
    protected function getScripts($config)
    {
        return isset($config['scripts']) ? $config['scripts'] : array();
    }

    /**
     * @param array $config
     *
     * @return array
     */
    protected function getStyles($config)
    {
        return isset($config['styles']) ? $config['styles'] : array();
    }

    /**
     * @param array $config
     *
     * @return array
     */
    protected function getOptions($config)
    {
        return isset($config['options']) ? $config['options'] : array();
    }
}
