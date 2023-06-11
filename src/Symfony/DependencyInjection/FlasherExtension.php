<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Prime\Http\RequestExtension;
use Flasher\Prime\Http\ResponseExtension;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Flasher\Symfony\EventListener\FlasherListener;
use Flasher\Symfony\EventListener\SessionListener;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @phpstan-type FlasherConfigType array{
 *
 * }
 */
final class FlasherExtension extends Extension implements CompilerPassInterface
{
    public function __construct(private readonly FlasherPlugin $plugin)
    {
    }

    public function getAlias(): string
    {
        return $this->plugin->getName();
    }

    public function getConfiguration(array $config, ContainerBuilder $container): ConfigurationInterface
    {
        return new Configuration($this->plugin);
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        /** @phpstan-var FlasherConfigType $config */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $this->registerCompilerPassTags($container);
        $this->registerFlasherConfiguration($config, $container);
        $this->registerListeners($config, $container);
        $this->registerStorageManager($config, $container);
        $this->registerHttpExtensions($config, $container);
    }

    public function process(ContainerBuilder $container): void
    {
        $this->registerFlasherTranslator($container);
        $this->registerFlasherTemplateEngine($container);
        $this->configureSessionServices($container);
    }

    private function registerCompilerPassTags(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(EventListenerInterface::class)
            ->addTag('flasher.event_listener');
    }

    /**
     * @phpstan-param FlasherConfigType $config
     */
    private function registerFlasherConfiguration(array $config, ContainerBuilder $container): void
    {
        $flasherConfig = $container->getDefinition('flasher.config');
        $flasherConfig->replaceArgument(0, $config);

        $flasher = $container->getDefinition('flasher');
        $flasher->replaceArgument(0, $config['default']);

        $presetListener = $container->getDefinition('flasher.preset_listener');
        $presetListener->replaceArgument(0, $config['presets']);
    }

    /**
     * @phpstan-param FlasherConfigType $config
     */
    private function registerListeners(array $config, ContainerBuilder $container): void
    {
        $this->registerSessionListener($config, $container);
        $this->registerFlasherListener($config, $container);
    }

    private function registerResponseExtension(ContainerBuilder $container): void
    {
        $container->register('flasher.response_extension', ResponseExtension::class)
            ->addArgument(new Reference('flasher'));
    }

    private function registerRequestExtension(ContainerBuilder $container, array $mapping): void
    {
        $container->register('flasher.request_extension', RequestExtension::class)
            ->addArgument(new Reference('flasher'))
            ->addArgument($mapping);
    }

    /**
     * @phpstan-param FlasherConfigType $config
     */
    private function registerSessionListener(array $config, ContainerBuilder $container): void
    {
        if (! $config['flash_bag']['enabled']) {
            return;
        }

        $container->register('flasher.session_listener', SessionListener::class)
            ->addArgument(new Reference('flasher.request_extension'))
            ->addTag('kernel.event_listener', ['event' => 'kernel.response']);
    }

    /**
     * @phpstan-param FlasherConfigType $config
     */
    private function registerFlasherListener(array $config, ContainerBuilder $container): void
    {
        if (! $config['auto_render']) {
            return;
        }

        $container->register('flasher.flasher_listener', FlasherListener::class)
            ->addArgument(new Reference('flasher.response_extension'))
            ->addTag('kernel.event_listener', ['event' => 'kernel.response', 'priority' => -256]);
    }

    /**
     * @phpstan-param FlasherConfigType $config
     */
    private function registerStorageManager(array $config, ContainerBuilder $container): void
    {
        $criteria = $config['filter_criteria'];
        $storageManager = $container->getDefinition('flasher.storage_manager');
        $storageManager->replaceArgument(3, $criteria);
    }

    /**
     * @phpstan-param FlasherConfigType $config
     */
    private function registerHttpExtensions(array $config, ContainerBuilder $container): void
    {
        $mapping = $config['flash_bag']['mapping'];
        $this->registerRequestExtension($container, $mapping);

        $this->registerResponseExtension($container);
    }

    private function registerFlasherTranslator(ContainerBuilder $container): void
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

    private function registerFlasherTemplateEngine(ContainerBuilder $container): void
    {
        if ($container->has('twig')) {
            return;
        }

        $container->removeDefinition('flasher.template_engine');

        $listener = $container->getDefinition('flasher.resource_manager');
        $listener->replaceArgument(1, null);
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
