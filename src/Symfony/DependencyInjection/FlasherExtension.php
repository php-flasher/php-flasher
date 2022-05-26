<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherExtension extends Extension
{
    /**
     * @param array<int, array<string, mixed>> $configs
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        $configs = $this->processConfiguration(new Configuration(), $configs);

        $this->registerFlasherConfiguration($configs, $container);
        $this->registerSessionListener($configs, $container, $loader);
    }

    /**
     * @param array<int, array<string, mixed>> $configs
     *
     * @return void
     */
    private function registerFlasherConfiguration(array $configs, ContainerBuilder $container)
    {
        $config = $container->getDefinition('flasher.config');
        $config->replaceArgument(0, $configs);

        $flasher = $container->getDefinition('flasher');
        $flasher->replaceArgument(0, $configs['default']); // @phpstan-ignore-line

        $translationListener = $container->getDefinition('flasher.translation_listener');
        $translationListener->replaceArgument(1, $configs['translate_by_default']); // @phpstan-ignore-line
    }

    /**
     * @param array{flash_bag?: array{enabled: bool, mapping: array<string, string[]>}} $configs
     *
     * @return void
     */
    private function registerSessionListener(array $configs, ContainerBuilder $container, Loader\PhpFileLoader $loader)
    {
        if (!isset($configs['flash_bag']['enabled']) || true !== $configs['flash_bag']['enabled']) {
            return;
        }

        $loader->load('session_listener.php');

        $listener = $container->getDefinition('flasher.session_listener');
        $listener->replaceArgument(1, $configs['flash_bag']['mapping']);
    }
}
