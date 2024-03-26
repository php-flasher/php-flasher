<?php

declare(strict_types=1);

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class PluginExtension extends Extension implements PrependExtensionInterface
{
    public function __construct(private readonly PluginInterface $plugin)
    {
    }

    public function getAlias(): string
    {
        return $this->plugin->getName();
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $definition = new ChildDefinition('flasher.notification_factory');
        $definition
            ->setClass($this->plugin->getFactory())
            ->setPublic(true)
            ->addTag('flasher.factory', ['alias' => $this->plugin->getAlias()]);

        $identifier = $this->plugin->getServiceId();
        $container->setDefinition($identifier, $definition);

        foreach ((array) $this->plugin->getServiceAliases() as $alias) {
            $container->setAlias($alias, $identifier);
        }
    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('flasher', [
            'plugins' => [
                $this->plugin->getAlias() => [
                    'scripts' => (array) $this->plugin->getScripts(),
                    'styles' => (array) $this->plugin->getStyles(),
                    'options' => $this->plugin->getOptions(),
                ],
            ],
        ]);
    }
}
