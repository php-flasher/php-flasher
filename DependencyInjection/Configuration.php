<?php

namespace Flasher\Pnotify\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('notify_pnotify');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('notify_pnotify');
        }

        $rootNode
            ->children()
                ->arrayNode('scripts')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js',
                        'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js',
                    ))
                ->end()
                ->arrayNode('styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(array(
                        'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css',
                        'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css',
                    ))
                ->end()
                ->arrayNode('options')
                    ->prototype('variable')->end()
                    ->ignoreExtraKeys(false)
                    ->defaultValue(array(
                        'type'             => 'notice',
                        'title'            => false,
                        'titleTrusted'     => false,
                        'text'             => false,
                        'textTrusted'      => false,
                        'styling'          => 'brighttheme',
                        'icons'            => 'brighttheme',
                        'mode'             => 'no-preference',
                        'addClass'         => '',
                        'addModalClass'    => '',
                        'addModelessClass' => '',
                        'autoOpen'         => true,
                        'width'            => '360px',
                        'minHeight'        => '16px',
                        'maxTextHeight'    => '200px',
                        'icon'             => true,
                        'animation'        => 'fade',
                        'animateSpeed'     => 'normal',
                        'shadow'           => true,
                        'hide'             => true,
                        'delay'            => 5000,
                        'mouseReset'       => true,
                        'closer'           => true,
                        'closerHover'      => true,
                        'sticker'          => true,
                        'stickerHover'     => true,
                        'labels'           => array(
                            'close'   => 'Close',
                            'stick'   => 'Pin',
                            'unstick' => 'Unpin'
                        ),
                        'remove'           => true,
                        'destroy'          => true,
                    ))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
