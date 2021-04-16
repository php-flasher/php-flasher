<?php

namespace Flasher\Notyf\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flasher_notyf');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('flasher_notyf');
        }

        $rootNode
            ->children()
                ->arrayNode('scripts')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@0.1.5/dist/flasher-notyf.min.js',
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
                        'duration' => 5000,
                        'types' => array(
                            array(
                                'type'            => 'info',
                                'className'       => 'notyf__toast--info',
                                'backgroundColor' => '#5784E5',
                                'icon'            => false,
                            ),
                            array(
                                'type'            => 'warning',
                                'className'       => 'notyf__toast--warning',
                                'backgroundColor' => '#E3A008',
                                'icon'            => false,
                            )
                        ),
                    ))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
