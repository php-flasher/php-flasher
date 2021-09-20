<?php

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Flasher\Symfony\DependencyInjection\FlasherExtensionInterface;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ResourceCompilerPass implements CompilerPassInterface
{
    private $extension;

    public function __construct(FlasherExtensionInterface $extension)
    {
        $this->extension = $extension;
    }

    public function process(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->extension->getAlias());
        $config = $this->processConfiguration($this->extension->getConfigurationClass(), $configs);

        $responseManager = $container->getDefinition('flasher.resource_manager');
        $responseManager->addMethodCall('addScripts', array($this->getHandlerAlias(), $this->getScripts($config)));
        $responseManager->addMethodCall('addStyles', array($this->getHandlerAlias(), $this->getStyles($config)));
        $responseManager->addMethodCall('addOptions', array($this->getHandlerAlias(), $this->getOptions($config)));
    }

    protected function processConfiguration(ConfigurationInterface $configuration, array $configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }

    /**
     * @return string
     */
    protected function getHandlerAlias()
    {
        return str_replace('flasher_', '', $this->extension->getAlias());
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
