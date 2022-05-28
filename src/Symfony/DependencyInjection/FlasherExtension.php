<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @phpstan-type ConfigType array{
 *   default: string,
 *   root_script: string,
 *   themes: array<string, array{
 *      view: string,
 *      styles: string[],
 *      scripts: string[],
 *      options: array<string, mixed>,
 *   }>,
 *   translate_by_default: bool,
 *   flash_bag?: array{
 *      enabled: bool,
 *      mapping: array<string, string>,
 *   },
 * }
 */
final class FlasherExtension extends Extension implements CompilerPassInterface
{
    /**
     * @phpstan-param ConfigType[] $configs
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        /** @var ConfigType $config */
        $config = $this->processConfiguration(new Configuration(), $configs);

        $this->registerFlasherConfiguration($config, $container);
        $this->registerSessionListener($config, $container, $loader);
    }

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getDefinition('flasher.config')->getArgument(0);

        $translationListener = $container->getDefinition('flasher.translation_listener');
        $translationListener->replaceArgument(1, $config['auto_translate']);

        if ($container->has('translator')) {
            return;
        }

        $container->removeDefinition('flasher.translator');
        $translationListener->replaceArgument(0, null);
    }

    /**
     * @phpstan-param ConfigType $config
     *
     * @return void
     */
    private function registerFlasherConfiguration(array $config, ContainerBuilder $container)
    {
        $flasherConfig = $container->getDefinition('flasher.config');
        $flasherConfig->replaceArgument(0, $config);

        $flasher = $container->getDefinition('flasher');
        $flasher->replaceArgument(0, $config['default']);

        $presetListener = $container->getDefinition('flasher.preset_listener');
        $presetListener->replaceArgument(0, $config['presets']);
    }

    /**
     * @phpstan-param ConfigType $config
     *
     * @return void
     */
    private function registerSessionListener(array $config, ContainerBuilder $container, Loader\PhpFileLoader $loader)
    {
        if (!isset($config['flash_bag']['enabled']) || true !== $config['flash_bag']['enabled']) {
            return;
        }

        $loader->load('session_listener.php');

        $listener = $container->getDefinition('flasher.session_listener');
        $listener->replaceArgument(1, $config['flash_bag']['mapping']);
    }
}
