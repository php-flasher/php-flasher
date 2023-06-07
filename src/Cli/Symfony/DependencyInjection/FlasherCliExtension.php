<?php

declare(strict_types=1);

namespace Flasher\Cli\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class FlasherCliExtension extends Extension
{
    /**
     * @param  array<int, array<string, mixed>>  $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configs = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        $this->configureNotifier($configs, $container);
    }

    /**
     * @param  array<int, array<string, mixed>>  $configs
     */
    private function configureNotifier(array $configs, ContainerBuilder $container): void
    {
        $notifier = $container->getDefinition('flasher.notify');
        $notifier->replaceArgument(0, $configs['title']); // @phpstan-ignore-line
        $notifier->replaceArgument(1, $configs['icons']); // @phpstan-ignore-line
    }
}
