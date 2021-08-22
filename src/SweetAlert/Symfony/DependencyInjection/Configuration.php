<?php

namespace Flasher\SweetAlert\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flasher_sweet_alert');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('flasher_sweet_alert');
        }

        $rootNode
            ->children()
                ->arrayNode('scripts')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
                        'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweet-alert@0.1.6/dist/flasher-sweet-alert.min.js',
                    ))
                ->end()
                ->arrayNode('styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('options')
                    ->ignoreExtraKeys(false)
                    ->prototype('variable')->end()
                    ->defaultValue(array(
                        'timer' => 5000,
                        'timerProgressBar' => true,
                    ))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
