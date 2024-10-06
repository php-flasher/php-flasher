<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Flasher\Symfony\Attribute\AsFlasherFactory;
use Flasher\Symfony\Attribute\AsFlasherPresenter;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

final class FlasherExtension extends AbstractExtension implements CompilerPassInterface
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

    /**
     * @param array{
     *     default: string,
     *     main_script: string,
     *     inject_assets: bool,
     *     excluded_paths: list<non-empty-string>,
     *     presets: array<string, mixed>,
     *     flash_bag: array<string, mixed>,
     *     filter: array<string, mixed>,
     *     plugins: array<array<string, mixed>>,
     * } $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $this->registerFlasherParameters($config, $container, $builder);
        $this->registerServicesForAutoconfiguration($builder);

        $container->import(__DIR__.'/../Resources/config/services.php');
    }

    public function process(ContainerBuilder $container): void
    {
        $this->registerFlasherTranslator($container);
        $this->configureSessionServices($container);
        $this->configureFlasherListener($container);
    }

    /**
     * @param array{
     *     default: string,
     *     main_script: string,
     *     inject_assets: bool,
     *     excluded_paths: list<non-empty-string>,
     *     presets: array<string, mixed>,
     *     flash_bag: array<string, mixed>,
     *     filter: array<string, mixed>,
     *     plugins: array<array<string, mixed>>,
     * } $config
     */
    private function registerFlasherParameters(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        /** @var string $projectDir */
        $projectDir = $builder->getParameter('kernel.project_dir');
        $publicDir = $projectDir.\DIRECTORY_SEPARATOR.'public';
        $assetsDir = $publicDir.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'flasher';
        $manifestPath = $assetsDir.\DIRECTORY_SEPARATOR.'manifest.json';

        $container->parameters()
            ->set('flasher', $config)
            ->set('flasher.public_dir', $publicDir)
            ->set('flasher.assets_dir', $assetsDir)
            ->set('flasher.json_manifest_path', $manifestPath)
            ->set('flasher.default', $config['default'])
            ->set('flasher.main_script', $config['main_script'])
            ->set('flasher.inject_assets', $config['inject_assets'])
            ->set('flasher.excluded_paths', $config['excluded_paths'])
            ->set('flasher.flash_bag', $config['flash_bag'])
            ->set('flasher.filter', $config['filter'])
            ->set('flasher.presets', $config['presets'])
            ->set('flasher.plugins', $config['plugins'])
        ;
    }

    private function registerServicesForAutoconfiguration(ContainerBuilder $builder): void
    {
        $builder->registerForAutoconfiguration(EventListenerInterface::class)
            ->addTag('flasher.event_listener');

        $builder->registerAttributeForAutoconfiguration(AsFlasherFactory::class, static function (ChildDefinition $definition, AsFlasherFactory $attribute): void {
            $definition->addTag('flasher.factory', get_object_vars($attribute));
        });

        $builder->registerAttributeForAutoconfiguration(AsFlasherPresenter::class, static function (ChildDefinition $definition, AsFlasherPresenter $attribute): void {
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
        if (!$container->has('session.factory') || false === $container->getParameter('flasher.flash_bag')) {
            $container->removeDefinition('flasher.session_listener');
        }

        if (!$container->has('session.factory')) {
            $container->removeDefinition('flasher.storage_bag');
            $container->register('flasher.storage_bag', ArrayBag::class);
        }
    }

    private function configureFlasherListener(ContainerBuilder $container): void
    {
        if ($container->getParameter('flasher.inject_assets')) {
            return;
        }

        $container->removeDefinition('flasher.flasher_listener');
    }
}
