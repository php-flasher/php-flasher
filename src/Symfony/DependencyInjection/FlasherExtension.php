<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Symfony\Bridge\Bridge;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @phpstan-import-type ConfigType from ConfigInterface
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
        $this->registerListeners($config, $container);
        $this->registerStorageManager($config, $container);
        $this->registerHttpExtensions($config, $container);
        $this->registerFlasherAutoConfiguration($container);
    }

    /**
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        $this->registerFlasherTranslator($container);
        $this->registerFlasherTemplateEngine($container);
        $this->configureSessionServices($container);
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
    private function registerListeners(array $config, ContainerBuilder $container)
    {
        $this->registerSessionListener($config, $container);
        $this->registerFlasherListener($config, $container);
    }

    /**
     * @return void
     */
    private function registerResponseExtension(ContainerBuilder $container)
    {
        $container->register('flasher.response_extension', 'Flasher\Prime\Http\ResponseExtension')
            ->setPublic(false)
            ->addArgument(new Reference('flasher'));
    }

    /**
     * @param array<string, string[]> $mapping
     *
     * @return void
     */
    private function registerRequestExtension(ContainerBuilder $container, array $mapping)
    {
        $container->register('flasher.request_extension', 'Flasher\Prime\Http\RequestExtension')
            ->setPublic(false)
            ->addArgument(new Reference('flasher'))
            ->addArgument($mapping);
    }

    /**
     * @phpstan-param ConfigType $config
     *
     * @return void
     */
    private function registerSessionListener(array $config, ContainerBuilder $container)
    {
        if (!$config['flash_bag']['enabled']) {
            return;
        }

        $container->register('flasher.session_listener', 'Flasher\Symfony\EventListener\SessionListener')
            ->setPublic(true)
            ->addArgument(new Reference('flasher.request_extension'))
            ->addTag('kernel.event_listener', array('event' => 'kernel.response'));
    }

    /**
     * @phpstan-param ConfigType $config
     *
     * @return void
     */
    private function registerFlasherListener(array $config, ContainerBuilder $container)
    {
        if (!$config['auto_render']) {
            return;
        }

        $container->register('flasher.flasher_listener', 'Flasher\Symfony\EventListener\FlasherListener')
            ->setPublic(true)
            ->addArgument(new Reference('flasher.response_extension'))
            ->addTag('kernel.event_listener', array('event' => 'kernel.response', 'priority' => -256));
    }

    /**
     * @phpstan-param ConfigType $config
     *
     * @return void
     */
    private function registerStorageManager(array $config, ContainerBuilder $container)
    {
        $criteria = $config['filter_criteria'];
        $storageManager = $container->getDefinition('flasher.storage_manager');
        $storageManager->replaceArgument(2, $criteria);
    }

    /**
     * @return void
     */
    private function registerHttpExtensions(array $config, ContainerBuilder $container)
    {
        $mapping = $config['flash_bag']['mapping'];
        $this->registerRequestExtension($container, $mapping);

        $this->registerResponseExtension($container);
    }

    /**
     * @return void
     */
    private function registerFlasherAutoConfiguration(ContainerBuilder $container)
    {
        if (!method_exists($container, 'registerForAutoconfiguration')) {
            return;
        }

        $container
            ->registerForAutoconfiguration('Flasher\Prime\Aware\FlasherAwareInterface')
            ->addTag('flasher.flasher_aware');
    }

    /**
     * @return void
     */
    private function registerFlasherTranslator(ContainerBuilder $container)
    {
        $config = $container->getDefinition('flasher.config')->getArgument(0);

        $translationListener = $container->getDefinition('flasher.translation_listener');
        $translationListener->replaceArgument(1, $config['auto_translate']); // @phpstan-ignore-line

        if ($container->has('translator')) {
            return;
        }

        $container->removeDefinition('flasher.translator');
        $translationListener->replaceArgument(0, null);
    }

    /**
     * @return void
     */
    private function registerFlasherTemplateEngine(ContainerBuilder $container)
    {
        if ($container->has('twig')) {
            return;
        }

        $container->removeDefinition('flasher.template_engine');

        $listener = $container->getDefinition('flasher.resource_manager');
        $listener->replaceArgument(1, null);
    }

    /**
     * @return void
     */
    private function configureSessionServices(ContainerBuilder $container)
    {
        if ($this->isSessionEnabled($container)) {
            return;
        }

        $container->removeDefinition('flasher.storage_bag');
        $container->removeDefinition('flasher.session_listener');

        $container->register('flasher.storage_bag', 'Flasher\Prime\Storage\Bag\ArrayBag');
    }

    /**
     * @return bool
     */
    private function isSessionEnabled(ContainerBuilder $container)
    {
        if (Bridge::versionCompare('5.3', '>=')) {
            return $container->has('session.factory');
        }

        return $container->has('session');
    }
}
