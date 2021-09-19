<?php

namespace Flasher\Console\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherConsoleExtension extends Extension
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, $this->getConfigFileLocator());
        $loader->load('config.yaml');

        $this->configureNotifySend($config, $container);

        $container
            ->findDefinition('flasher.console')
            ->replaceArgument(2, $config['filter_criteria']);
    }

    protected function getConfigFileLocator()
    {
        return new FileLocator(__DIR__ . '/../Resources/config');
    }

    private function configureNotifySend(array $config, ContainerBuilder $container)
    {
        $notifySendConfig = $config['notify_send'];

        $notifySendConfig['icons'] = array_replace($config['icons'], $notifySendConfig['icons']);

        $notifySendConfig['title'] = $config['title'];
        $notifySendConfig['mute'] = $config['mute'];

        $container
            ->findDefinition('flasher.console.notify_send')
            ->replaceArgument(0, $notifySendConfig);
    }
}
