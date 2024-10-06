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
                    ->info('Default notification library (e.g., "flasher", "toastr", "noty", "notyf", "sweetalert")')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->defaultValue($this->plugin->getDefault())
                ->end()
                ->scalarNode('main_script')
                    ->info('Path to the main PHPFlasher JavaScript file')
                    ->defaultValue($this->plugin->getRootScript())
                ->end()
                ->booleanNode('inject_assets')
                    ->info('Automatically inject assets into HTML pages')
                    ->defaultTrue()
                ->end()
                ->booleanNode('translate')
                    ->info('Enable message translation')
                    ->defaultTrue()
                ->end()
                ->arrayNode('excluded_paths')
                    ->info('URL patterns to exclude from asset injection and flash_bag conversion')
                    ->defaultValue([
                        '/^\/_profiler/',
                        '/^\/_fragment/',
                    ])
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('filter')
                    ->info('Criteria to filter notifications')
                    ->variablePrototype()->end()
                ->end()
                ->arrayNode('scripts')
                    ->info('Additional JavaScript files')
                    ->performNoDeepMerging()
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('styles')
                    ->info('CSS files to style notifications')
                    ->performNoDeepMerging()
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('options')
                    ->info('Global notification options')
                    ->variablePrototype()->end()
                ->end()
            ->end();
    }

    private function addFlashBagSection(ArrayNodeDefinition $rootNode): void
    {
        $rootNode
            ->children()
                ->variableNode('flash_bag')
                    ->info('Map Symfony flash messages to notification types')
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
                    ->info('Notification presets (optional)')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('type')
                                ->info('Notification type (e.g., "success", "error")')
                            ->end()
                            ->scalarNode('title')
                                ->info('Default title')
                            ->end()
                            ->scalarNode('message')
                                ->info('Default message')
                            ->end()
                            ->arrayNode('options')
                                ->info('Additional options')
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
                    ->info('Additional plugins')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('view')
                                ->info('Custom twig view template')
                            ->end()
                            ->arrayNode('styles')
                                ->info('CSS files for the plugin')
                                ->performNoDeepMerging()
                                ->scalarPrototype()->end()
                            ->end()
                            ->arrayNode('scripts')
                                ->info('JavaScript files for the plugin')
                                ->performNoDeepMerging()
                                ->scalarPrototype()->end()
                            ->end()
                            ->arrayNode('options')
                                ->info('Plugin-specific options')
                                ->variablePrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
