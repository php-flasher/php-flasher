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
        $treeBuilder = new TreeBuilder('notify_notyf');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('notify_notyf');
        }

        $rootNode
            ->children()
                ->arrayNode('scripts')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js',
                    ))
                ->end()
                ->arrayNode('styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css',
                    ))
                ->end()
                ->arrayNode('options')
                    ->ignoreExtraKeys(false)
                    ->prototype('variable')->end()
                    ->defaultValue(array(
                        'duration' => 5000,
                        'ripple' => true,
                        'position' => array(
                            'x' => 'right',
                            'y' => 'top',
                        ),
                        'dismissible' => false,
                        'types' => array(
                            array(
                                'type'            => 'success',
                                'className'       => 'notyf__toast--success',
                                'backgroundColor' => '#3dc763',
                                'icon'            => array(
                                    'className' => 'notyf__icon--success',
                                    'tagName'   => 'i',
                                ),
                            ),
                            array(
                                'type'            => 'error',
                                'className'       => 'notyf__toast--error',
                                'backgroundColor' => '#ed3d3d',
                                'icon'            => array(
                                    'className' => 'notyf__icon--error',
                                    'tagName'   => 'i',
                                ),
                            ),
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
