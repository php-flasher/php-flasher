<?php

namespace Flasher\Toastr\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flasher_toastr');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('flasher_toastr');
        }

        $rootNode
            ->children()
                ->arrayNode('scripts')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js',
                        '/bundles/flashertoastr/flasher-toastr.js',
                    ))
                ->end()
                ->arrayNode('styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',
                    ))
                ->end()
                ->arrayNode('options')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
