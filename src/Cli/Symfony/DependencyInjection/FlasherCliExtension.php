<?php

namespace Flasher\Cli\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherCliExtension extends Extension
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('config.php');

        // $this->registerFlasherCliConfigration($config, $container);
        // $this->registerNotifySendConfigration($config, $container);
    }

    private function registerFlasherCliConfigration(array $config, ContainerBuilder $container)
    {
        $container
            ->findDefinition('flasher.console')
            ->replaceArgument(2, $config['filter_criteria']);
    }

    private function registerNotifySendConfigration(array $config, ContainerBuilder $container)
    {
        $notifySendConfig = $config['notify_send'];

        $notifySendConfig['icons'] = array_replace_recursive($config['icons'], $notifySendConfig['icons']);

        $notifySendConfig['title'] = $config['title'];
        $notifySendConfig['mute'] = $config['mute'];

        $container
            ->findDefinition('flasher.console.notify_send')
            ->replaceArgument(0, $notifySendConfig);
    }
}
