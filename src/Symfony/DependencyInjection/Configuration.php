<?php

declare(strict_types=1);

namespace Flasher\Symfony\DependencyInjection;

use Flasher\Prime\Plugin\FlasherPlugin;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function __construct(private readonly FlasherPlugin $plugin)
    {
    }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder($this->plugin->getName());

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $this->normalizeConfig($rootNode);
        $this->addGeneralSection($rootNode);
        $this->addThemesSection($rootNode);
        $this->addFlashBagSection($rootNode);
        $this->addPresetsSection($rootNode);
        $this->addPluginsSection($rootNode);

        return $treeBuilder;
    }

    private function normalizeConfig(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->beforeNormalization()
            ->always(fn ($v) => $this->plugin->normalizeConfig($v))
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
            ->scalarNode('root_script')
            ->defaultValue($this->plugin->getRootScript())
            ->end()
            ->arrayNode('scripts')
            ->scalarPrototype()->end()
            ->end()
            ->arrayNode('styles')
            ->scalarPrototype()->end()
            ->defaultValue($this->plugin->getStyles())
            ->end()
            ->arrayNode('options')
            ->variablePrototype()->end()
            ->end()
            ->booleanNode('use_cdn')
            ->defaultTrue()
            ->end()
            ->booleanNode('auto_translate')
            ->defaultTrue()
            ->end()
            ->booleanNode('auto_render')
            ->defaultTrue()
            ->end()
            ->arrayNode('filter_criteria')
            ->variablePrototype()->end()
            ->end()
            ->end();
    }

    private function addThemesSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode // @phpstan-ignore-line
            ->fixXmlConfig('theme')
            ->children()
            ->arrayNode('themes')
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->arrayNode('styles')
            ->scalarPrototype()->end()
            ->end()
            ->arrayNode('scripts')
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

    private function addFlashBagSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode // @phpstan-ignore-line
            ->children()
            ->arrayNode('flash_bag')
            ->children()
            ->booleanNode('enabled')
            ->defaultTrue()
            ->end()
            ->arrayNode('mapping')
            ->useAttributeAsKey('name')
            ->variablePrototype()->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addPresetsSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode // @phpstan-ignore-line
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
        $rootNode // @phpstan-ignore-line
            ->fixXmlConfig('plugin')
            ->children()
            ->arrayNode('plugins')
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->arrayNode('styles')
            ->scalarPrototype()->end()
            ->end()
            ->arrayNode('scripts')
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
