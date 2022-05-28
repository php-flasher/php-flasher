<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\Plugin\FlasherPlugin;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $plugin = new FlasherPlugin();

        $treeBuilder = new TreeBuilder($plugin->getName());

        $rootNode = method_exists($treeBuilder, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root($plugin->getName()); // @phpstan-ignore-line

        $rootNode
             ->beforeNormalization()
                ->always(function ($v) use ($plugin) {
                    return $plugin->normalizeConfig($v);
                })
            ->end()
            ->children()
                ->scalarNode('default')
                    ->cannotBeEmpty()
                    ->defaultValue($plugin->getDefault())
                ->end()
                ->scalarNode('root_script')
                    ->defaultValue($plugin->getRootScript())
                ->end()
                ->arrayNode('themes')
                    ->ignoreExtraKeys()
                    ->prototype('variable')->end()
                    ->children()
                        ->scalarNode('view')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode('styles')->end()
                        ->arrayNode('scripts')->end()
                        ->arrayNode('options')->end()
                    ->end()
                ->end()
                ->booleanNode('translate_by_default')->defaultTrue()->end()
            ->end()
        ;

        $this->addFlashBagSection($rootNode, $plugin);

        return $treeBuilder;
    }

    /**
     * @return void
     */
    private function addFlashBagSection(ArrayNodeDefinition $rootNode, FlasherPlugin $plugin)
    {
        $rootNode // @phpstan-ignore-line
            ->children()
                ->arrayNode('flash_bag')
                    ->canBeUnset()
                    ->addDefaultsIfNotSet()
                    ->beforeNormalization()
                        ->always(function ($v) use ($plugin) {
                            return $plugin->normalizeFlashBagConfig($v);
                        })
                    ->end()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->arrayNode('mapping')
                            ->prototype('variable')->end()
                            ->defaultValue($plugin->getFlashBagMapping())
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
