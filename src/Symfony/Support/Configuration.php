<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Bridge\DependencyInjection\FlasherConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends FlasherConfiguration
{
    /**
     * @var PluginInterface
     */
    private $plugin;

    public function __construct(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getFlasherConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder($this->plugin->getName());

        $rootNode = method_exists($treeBuilder, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root($this->plugin->getName()); // @phpstan-ignore-line

        $plugin = $this->plugin;
        $rootNode
            ->beforeNormalization()
                ->always(function ($v) use ($plugin) {
                    return $plugin->normalizeConfig($v);
                })
            ->end()
            ->children()
                ->arrayNode('scripts')
                    ->prototype('variable')->end()
                    ->defaultValue($this->plugin->getScripts())
                ->end()
                ->arrayNode('styles')
                    ->prototype('variable')->end()
                    ->defaultValue($this->plugin->getStyles())
                ->end()
                ->arrayNode('options')
                    ->prototype('variable')->end()
                    ->ignoreExtraKeys(false)
                    ->defaultValue($this->plugin->getOptions())
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
