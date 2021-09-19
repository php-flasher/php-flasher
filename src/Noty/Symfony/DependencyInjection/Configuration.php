<?php

namespace Flasher\Noty\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flasher_noty');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('flasher_noty');
        }

        $rootNode
            ->children()
                ->arrayNode('scripts')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@0.1.8/dist/flasher-noty.min.js',
                    ))
                ->end()
                ->arrayNode('styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('options')
                    ->prototype('variable')->end()
                    ->ignoreExtraKeys(false)
                    ->defaultValue(array(
                        'timeout' => 5000,
                    ))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
