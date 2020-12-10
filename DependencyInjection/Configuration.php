<?php

namespace Flasher\Noty\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
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
                          'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js',
                          '/bundles/flashernoty/flasher-noty.js',
                    ))
                ->end()
                ->arrayNode('styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                          'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css',
                    ))
                ->end()
                ->arrayNode('options')
                    ->prototype('variable')->end()
                    ->ignoreExtraKeys(false)
                    ->defaultValue(array(
                        'layout' => 'topRight',
                        'theme' => 'mint',
                        'timeout' => false,
                        'progressBar' => true,
                        'animation.open' => 'noty_effects_open',
                        'animation.close' => 'noty_effects_close',
                        'sounds.sources' => array(),
                        'closeWith' => array('click'),
                        'sounds.volume' => 1,
                        'sounds.conditions' => array(),
                        'docTitle.conditions' => array(),
                        'modal' => false,
                        'id' => false,
                        'force' => false,
                        'queue' => 'global',
                        'killer' => false,
                        'container' => false,
                        'buttons' => array(),
                        'visibilityControl' => false,
                    ))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
