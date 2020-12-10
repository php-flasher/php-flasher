<?php

namespace Flasher\SweetAlert\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flasher_sweet-alert');

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
                        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.2/sweetalert2.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/promise-polyfill/8.2.0/polyfill.min.js',
                        '/bundles/flashersweetalert/flasher-sweet-alert.js',
                    ))
                ->end()
                ->arrayNode('styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
                        'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.10.2/sweetalert2.min.css',
                    ))
                ->end()
                ->arrayNode('options')
                    ->ignoreExtraKeys(false)
                    ->prototype('variable')->end()
                    ->defaultValue(array(
                        'timer'             => 5000,
                      //'width'             => '32rem',
                      //'heightAuto'        => true,
                        'padding'           => '1.25rem',
                        'showConfirmButton' => false,
                        'showCloseButton'   => false,
                        'toast'             => true,
                        'position'          => 'top-end',
                        'timerProgressBar'  => true,
                        'animation'         => true,
                        'showClass'         => array(
                            'popup' => 'animate__animated animate__fadeInDown',
                        ),
                        'hideClass'         => array(
                            'popup' => 'animate__animated animate__fadeOutUp',
                        ),
                        'backdrop'          => true,
                        'grow'              => true,
                    ))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
