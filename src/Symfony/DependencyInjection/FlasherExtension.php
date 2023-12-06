<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherExtension extends Extension implements CompilerPassInterface
{
    public function __construct(private readonly FlasherPlugin $plugin)
    {
    }

    public function getAlias(): string
    {
        return $this->plugin->getName();
    }

    /**
     * @param array<string, mixed> $config
     */
    public function getConfiguration(array $config, ContainerBuilder $container): ConfigurationInterface
    {
        return new Configuration($this->plugin);
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        /**
         * @var array{
         *     default: string,
         *     presets: array<string, mixed>,
         *     flash_bag: array<string, mixed>,
         *     filter: array<string, mixed>,
         * } $config
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $this->registerServicesForAutoconfiguration($container);
        $this->registerFlasherConfiguration($config, $container);
    }

    public function process(ContainerBuilder $container): void
    {
        $this->registerFlasherTranslator($container);
        $this->configureSessionServices($container);
    }

    private function registerServicesForAutoconfiguration(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(EventListenerInterface::class)
            ->addTag('flasher.event_listener');
    }

    /**
     * @param array{
     *     default: string,
     *     presets: array<string, mixed>,
     *     flash_bag: array<string, mixed>,
     *     filter: array<string, mixed>,
     * } $config
     */
    private function registerFlasherConfiguration(array $config, ContainerBuilder $container): void
    {
        $flasherConfig = $container->getDefinition('flasher.config');
        $flasherConfig->replaceArgument(0, $config);

        $flasher = $container->getDefinition('flasher');
        $flasher->replaceArgument(0, $config['default']);

        $presetListener = $container->getDefinition('flasher.preset_listener');
        $presetListener->replaceArgument(0, $config['presets']);

        $requestExtension = $container->getDefinition('flasher.request_extension');
        $requestExtension->replaceArgument(1, $config['flash_bag']);

        $storageManager = $container->getDefinition('flasher.storage_manager');
        $storageManager->replaceArgument(3, $config['filter']);
    }

    private function registerFlasherTranslator(ContainerBuilder $container): void
    {
        if ($container->has('translator')) {
            return;
        }

        $container->removeDefinition('flasher.translator');
    }

    private function configureSessionServices(ContainerBuilder $container): void
    {
        if ($this->isSessionEnabled($container)) {
            return;
        }

        $container->removeDefinition('flasher.storage_bag');
        $container->removeDefinition('flasher.session_listener');

        $container->register('flasher.storage_bag', ArrayBag::class);
    }

    private function isSessionEnabled(ContainerBuilder $container): bool
    {
        return $container->has('session.factory');
    }
}
