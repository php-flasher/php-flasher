<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $name = 'flasher_cli';

        $treeBuilder = new TreeBuilder($name);

        $rootNode = method_exists($treeBuilder, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root($name); // @phpstan-ignore-line

        $rootNode
            ->children()
                ->scalarNode('title')
                    ->defaultValue('PHPFlasher')
                ->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
