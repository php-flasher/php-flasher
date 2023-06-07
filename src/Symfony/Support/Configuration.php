<?php

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @var PluginInterface
     */
    private $plugin;

    public function __construct(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    public function getConfigTreeBuilder()
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
