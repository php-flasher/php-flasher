<?php

namespace Flasher\Cli\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flasher_console');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('flasher_console');
        }

        $rootNode
            ->children()
                ->scalarNode('title')
                    ->defaultValue('PHP Flasher')
                ->end()
                ->booleanNode('mute')
                    ->defaultValue(false)
                ->end()
                ->arrayNode('filter_criteria')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('notify_send')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('service')
                            ->defaultValue('flasher.console.notify_send')
                        ->end()
                        ->scalarNode('binary')
                            ->defaultValue('notify-send')
                            ->cannotBeEmpty()
                        ->end()
                        ->integerNode('expire_time')
                            ->defaultValue(0)
                        ->end()
                        ->booleanNode('enabled')
                            ->defaultValue(true)
                        ->end()
                        ->arrayNode('icons')
                            ->prototype('variable')->end()
                            ->defaultValue(array())
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
