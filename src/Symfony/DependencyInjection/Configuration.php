<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Symfony\Bridge\DependencyInjection\FlasherConfiguration;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

final class Configuration extends FlasherConfiguration
{
    /**
     * @return TreeBuilder
     */
    public function getFlasherConfigTreeBuilder()
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
                ->arrayNode('root_script')
                    ->prototype('scalar')->end()
                    ->defaultValue($plugin->getRootScript())
                ->end()
                ->arrayNode('scripts')
                    ->prototype('variable')->end()
                ->end()
                ->arrayNode('styles')
                    ->prototype('variable')->end()
                    ->defaultValue($plugin->getStyles())
                ->end()
                ->arrayNode('options')
                    ->prototype('scalar')->end()
                ->end()
                ->booleanNode('use_cdn')->defaultTrue()->end()
                ->booleanNode('auto_translate')->defaultTrue()->end()
                ->booleanNode('auto_render')->defaultTrue()->end()
                ->arrayNode('filter_criteria')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        $this->addThemesSection($rootNode);
        $this->addFlashBagSection($rootNode, $plugin);
        $this->addPresetsSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @return void
     */
    private function addThemesSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode // @phpstan-ignore-line
            ->children()
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
            ->end()
        ;
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

    /**
     * @return void
     */
    private function addPresetsSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode // @phpstan-ignore-line
            ->children()
                ->arrayNode('presets')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('type')->end()
                        ->scalarNode('title')->end()
                        ->scalarNode('message')->end()
                        ->arrayNode('options')
                            ->useAttributeAsKey('name')
                            ->prototype('variable')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
