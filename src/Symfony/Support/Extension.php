<?php

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Bridge\Bridge;
use Flasher\Symfony\Bridge\DependencyInjection\FlasherExtension;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

final class Extension extends FlasherExtension implements CompilerPassInterface
{
    /**
     * @var PluginInterface
     */
    private $plugin;

    public function __construct(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param array<int, array<string, mixed>> $configs
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        /** @var ChildDefinition $definition */
        $definition = class_exists('Symfony\Component\DependencyInjection\ChildDefinition')
            ? new ChildDefinition('flasher.notification_factory')
            : new DefinitionDecorator('flasher.notification_factory'); // @phpstan-ignore-line

        $definition
            ->setClass($this->plugin->getFactory())
            ->setPublic(true)
            ->addTag('flasher.factory', ['alias' => $this->plugin->getAlias()]);

        $identifier = $this->plugin->getServiceID();
        $container->setDefinition($identifier, $definition);

        if (Bridge::canLoadAliases()) {
            $container->setAlias($this->plugin->getFactory(), $identifier);
        }
    }

    public function getFlasherAlias()
    {
        return $this->plugin->getName();
    }

    /**
     * Returns extension configuration.
     *
     * @param array<int, array<string, mixed>> $config
     *
     * @return ConfigurationInterface|null
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($this->plugin);
    }

    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        $configs = $this->processConfiguration(
            new Configuration($this->plugin),
            $container->getExtensionConfig($this->plugin->getName())
        );

        $this->processResourceConfiguration($configs, $container);
    }

    /**
     * @param array<string, mixed> $configs
     *
     * @return void
     */
    protected function processResourceConfiguration(array $configs, ContainerBuilder $container)
    {
        if (!$container->has('flasher.resource_manager')) {
            return;
        }

        $definition = $container->getDefinition('flasher.resource_manager');
        $handler = $this->plugin->getAlias();

        $scripts = isset($configs['scripts']) ? $configs['scripts'] : [];
        $definition->addMethodCall('addScripts', [$handler, $scripts]);

        $styles = isset($configs['styles']) ? $configs['styles'] : [];
        $definition->addMethodCall('addStyles', [$handler, $styles]);

        $options = isset($configs['options']) ? $configs['options'] : [];
        $definition->addMethodCall('addOptions', [$handler, $options]);
    }
}
