<?php

namespace Flasher\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flasher');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('flasher');
        }

        $rootNode
            ->children()
                ->scalarNode('default')
                    ->cannotBeEmpty()
                    ->defaultValue('toastr')
                ->end()
                ->arrayNode('scripts')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        '/bundles/flasher/flasher.js'
                    ))
                ->end()
                ->arrayNode('styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(array())
                ->end()
                ->booleanNode('auto_create_from_session')
                    ->defaultValue(true)
                ->end()
                ->arrayNode('types_mapping')
                    ->prototype('variable')->end()
                    ->defaultValue(array(
                          'success' => array('success'),
                          'error'   => array('error', 'danger'),
                          'warning' => array('warning', 'alarm'),
                          'info'    => array('info', 'notice', 'alert'),
                     ))
                ->end()
                ->arrayNode('adapters')
                    ->ignoreExtraKeys(false)
                    ->useAttributeAsKey('name')
                    ->prototype('variable')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
