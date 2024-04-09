<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\Plugin\FlasherPlugin;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final readonly class Configuration implements ConfigurationInterface
{
    public function __construct(private FlasherPlugin $plugin)
    {
    }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder($this->plugin->getName());
        $rootNode = $treeBuilder->getRootNode();

        $this->normalizeConfig($rootNode);

        $this->addGeneralSection($rootNode);
        $this->addFlashBagSection($rootNode);
        $this->addPresetsSection($rootNode);
        $this->addPluginsSection($rootNode);

        return $treeBuilder;
    }

    private function normalizeConfig(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->beforeNormalization()
                ->always(fn ($v): array => $this->plugin->normalizeConfig($v))
            ->end();
    }

    private function addGeneralSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->scalarNode('default')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->defaultValue($this->plugin->getDefault())
                ->end()
                ->scalarNode('main_script')
                    ->defaultValue($this->plugin->getRootScript())
                ->end()
                ->booleanNode('translate')
                    ->defaultTrue()
                ->end()
                ->booleanNode('inject_assets')
                    ->defaultTrue()
                ->end()
                ->arrayNode('filter')
                    ->variablePrototype()->end()
                ->end()
                ->arrayNode('scripts')
                    ->performNoDeepMerging()
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('styles')
                    ->performNoDeepMerging()
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('options')
                    ->variablePrototype()->end()
                ->end()
            ->end();
    }

    private function addFlashBagSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->variableNode('flash_bag')
                    ->defaultTrue()
                ->end()
            ->end();
    }

    private function addPresetsSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->fixXmlConfig('preset')
            ->children()
                ->arrayNode('presets')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('type')->end()
                            ->scalarNode('title')->end()
                            ->scalarNode('message')->end()
                            ->arrayNode('options')
                                ->variablePrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addPluginsSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->fixXmlConfig('plugin')
            ->children()
                ->arrayNode('plugins')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('view')->end()
                            ->arrayNode('styles')
                                ->performNoDeepMerging()
                                ->scalarPrototype()->end()
                            ->end()
                            ->arrayNode('scripts')
                                ->performNoDeepMerging()
                                ->scalarPrototype()->end()
                            ->end()
                            ->arrayNode('options')
                                ->variablePrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
