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

        $container
            ->findDefinition('flasher.event_listener.cli_stamps_listener')
            ->replaceArgument(0, $config['render_all'])
            ->replaceArgument(1, $config['render_immediately']);

        $container
            ->findDefinition('flasher.cli')
            ->replaceArgument(2, $config['filter_criteria']);

        $this->registerNotifiersConfiguration($container, $config);
    }

    private function registerNotifiersConfiguration(ContainerBuilder $container, array $config)
    {
        $this->registerNotifier($container, $config, 'growl_notify');
        $this->registerNotifier($container, $config, 'kdialog_notifier');
        $this->registerNotifier($container, $config, 'notifu_notifier');
        $this->registerNotifier($container, $config, 'notify_send');
        $this->registerNotifier($container, $config, 'snore_toast_notifier');
        $this->registerNotifier($container, $config, 'terminal_notifier_notifier');
        $this->registerNotifier($container, $config, 'toaster');
        $this->registerNotifier($container, $config, 'apple_script');
    }

    private function registerNotifier(ContainerBuilder $container, array $config, $notifier)
    {
        $container
            ->findDefinition("flasher.cli.$notifier")
            ->replaceArgument(0, $this->createConfigFor($config, $notifier));
    }

    private function createConfigFor(array $config, $notifier)
    {
        $options = $config['notifiers'][$notifier];

        $options['title'] = $config['title'];
        $options['mute'] = $config['mute'];
        $options['icons'] = array_replace_recursive($config['icons'], $options['icons']);
        $options['sounds'] = array_replace_recursive($config['sounds'], $options['sounds']);

        return $options;
    }
}
