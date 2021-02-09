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
                ->arrayNode('root_scripts')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                       '/bundles/flasher/flasher.js',
                   ))
                ->end()
                ->arrayNode('template_factory')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->defaultValue('tailwindcss')
                        ->end()
                        ->arrayNode('templates')
                            ->ignoreExtraKeys()
                            ->prototype('scalar')->end()
                            ->children()
                                ->scalarNode('view')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->arrayNode('styles')->end()
                                ->arrayNode('scripts')->end()
                                ->arrayNode('options')->end()
                            ->end()
                            ->defaultValue(array(
                                'tailwindcss'    => array(
                                    'view'   => '@Flasher/tailwindcss.html.twig',
                                    'styles' => array(
                                        'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css',
                                    ),
                                ),
                                'tailwindcss_bg' => array(
                                    'view'   => '@Flasher/tailwindcss_bg.html.twig',
                                    'styles' => array(
                                        'https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css',
                                    ),
                                ),
                                'bootstrap'      => array(
                                    'view'   => '@Flasher/bootstrap.html.twig',
                                    'styles' => array(
                                        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css',
                                    ),
                                ),
                            ))
                        ->end()
                    ->end()
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
            ->end()
        ;

        return $treeBuilder;
    }
}
