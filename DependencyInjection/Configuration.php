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
                    ->ignoreExtraKeys(false)
                    ->defaultValue(array(
                        'closeButton'       => true,
                        'closeClass'        => 'toast-close-button',
                        'closeDuration'     => 300,
                        'closeEasing'       => 'swing',
                        'closeHtml'         => '<button><i class="icon-off"></i></button>',
                        'closeMethod'       => 'fadeOut',
                        'closeOnHover'      => true,
                        'containerId'       => 'toast-container',
                        'debug'             => false,
                        'escapeHtml'        => false,
                        'extendedTimeOut'   => 10000,
                        'hideDuration'      => 1000,
                        'hideEasing'        => 'linear',
                        'hideMethod'        => 'fadeOut',
                        'iconClass'         => 'toast-info',
                        'iconClasses'       => array(
                            'error'   => 'toast-error',
                            'info'    => 'toast-info',
                            'success' => 'toast-success',
                            'warning' => 'toast-warning',
                        ),
                        'messageClass'      => 'toast-message',
                        'newestOnTop'       => false,
                        'onHidden'          => null,
                        'onShown'           => null,
                        'positionClass'     => 'toast-top-right',
                        'preventDuplicates' => false,
                        'progressBar'       => true,
                        'progressClass'     => 'toast-progress',
                        'rtl'               => false,
                        'showDuration'      => 300,
                        'showEasing'        => 'swing',
                        'showMethod'        => 'fadeIn',
                        'tapToDismiss'      => true,
                        'target'            => 'body',
                        'timeOut'           => 5000,
                        'titleClass'        => 'toast-title',
                        'toastClass'        => 'toast',
                    ))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
