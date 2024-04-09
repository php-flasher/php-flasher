<?php

declare(strict_types=1);

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\FlasherSymfonyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

abstract class PluginBundle extends AbstractBundle implements PluginBundleInterface
{
    abstract public function createPlugin(): PluginInterface;

    /**
     * @param array<string, mixed> $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if ($this instanceof FlasherSymfonyBundle) {
            return;
        }

        $plugin = $this->createPlugin();
        $identifier = $plugin->getServiceId();

        $container->services()
            ->set($identifier, $plugin->getFactory())
            ->parent('flasher.notification_factory')
            ->tag('flasher.factory', ['alias' => $plugin->getAlias()])
            ->public()
        ;

        foreach ((array) $plugin->getServiceAliases() as $alias) {
            $builder->setAlias($alias, $identifier);
        }
    }

    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if ($this instanceof FlasherSymfonyBundle) {
            return;
        }

        $plugin = $this->createPlugin();

        $builder->prependExtensionConfig('flasher', [
            'plugins' => [
                $plugin->getAlias() => [
                    'scripts' => (array) $plugin->getScripts(),
                    'styles' => (array) $plugin->getStyles(),
                    'options' => $plugin->getOptions(),
                ],
            ],
        ]);
    }

    public function getConfigurationFile(): string
    {
        return rtrim($this->getPath(), '/').'/Resources/config/config.yaml';
    }

    public function getPath(): string
    {
        if (!isset($this->path)) {
            $reflected = new \ReflectionObject($this);
            // assume the modern directory structure by default
            $this->path = \dirname($reflected->getFileName() ?: '');
        }

        return $this->path;
    }
}
