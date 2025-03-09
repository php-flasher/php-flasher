<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * PresenterCompilerPass - Registers response presenters with the response manager.
 *
 * This compiler pass finds all services tagged with 'flasher.presenter'
 * and registers them with the PHPFlasher response manager. This allows for
 * automatic discovery and registration of response presenters.
 *
 * Design patterns:
 * - Compiler Pass: Modifies container definitions during compilation
 * - Service Discovery: Automatically discovers tagged services
 * - Strategy Pattern: Helps set up pluggable response presentation strategies
 */
final class PresenterCompilerPass implements CompilerPassInterface
{
    /**
     * Process the container to register presenters.
     *
     * @param ContainerBuilder $container The service container builder
     */
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition('flasher.response_manager');

        foreach ($container->findTaggedServiceIds('flasher.presenter') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addPresenter', [
                    $attributes['alias'],
                    new ServiceClosureArgument(new Reference($id)),
                ]);
            }
        }
    }
}
