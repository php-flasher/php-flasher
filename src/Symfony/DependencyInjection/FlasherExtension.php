<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Flasher\Symfony\Attribute\AsFlasherFactory;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ChildDefinition;
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

        $this->registerFlasherParameters($config, $container);
        $this->registerServicesForAutoconfiguration($container);
    }

    public function process(ContainerBuilder $container): void
    {
        $this->registerFlasherTranslator($container);
        $this->configureSessionServices($container);
    }

    /**
     * @param array{
     *     default: string,
     *     presets: array<string, mixed>,
     *     flash_bag: array<string, mixed>,
     *     filter: array<string, mixed>,
     * } $config
     */
    private function registerFlasherParameters(array $config, ContainerBuilder $container): void
    {
        $container->setParameter('flasher', $config);
        $container->setParameter('flasher.default', $config['default']);
        $container->setParameter('flasher.flash_bag', $config['flash_bag']);
        $container->setParameter('flasher.filter', $config['filter']);
        $container->setParameter('flasher.presets', $config['presets']);
    }

    private function registerServicesForAutoconfiguration(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(EventListenerInterface::class)
            ->addTag('flasher.event_listener');

        $container->registerAttributeForAutoconfiguration(AsFlasherFactory::class, static function (ChildDefinition $definition, AsFlasherFactory $attribute): void {
            $definition->addTag('flasher.factory', get_object_vars($attribute));
        });

        $container->registerAttributeForAutoconfiguration(AsFlasherFactory::class, static function (ChildDefinition $definition, AsFlasherFactory $attribute): void {
            $definition->addTag('flasher.presenter', get_object_vars($attribute));
        });
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
        if ($container->has('session.factory')) {
            return;
        }

        $container->removeDefinition('flasher.storage_bag');
        $container->removeDefinition('flasher.session_listener');

        $container->register('flasher.storage_bag', ArrayBag::class);
    }
}
