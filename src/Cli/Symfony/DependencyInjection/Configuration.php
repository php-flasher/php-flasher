<?php

namespace Flasher\Cli\Symfony\DependencyInjection;

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
        $name = 'flasher_cli';
        $treeBuilder = new TreeBuilder($name);
        $rootNode = $this->getRootNode($treeBuilder, $name);

        $rootNode
            ->children()
                ->booleanNode('render_all')
                    ->defaultValue(true)
                ->end()
                ->booleanNode('render_immediately')
                    ->defaultValue(true)
                ->end()
                ->scalarNode('title')
                    ->defaultValue('PHP Flasher')
                ->end()
                ->booleanNode('mute')
                    ->defaultValue(true)
                ->end()
                ->arrayNode('filter_criteria')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->append($this->addNotifiersConfig())
            ->end()
        ;

        return $treeBuilder;
    }

    private function addNotifiersConfig()
    {
        $name = 'notifiers';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->fixXmlConfig('notifier')
            ->children()
                ->append($this->addGrowlNotifyNotifier())
                ->append($this->addKDialogNotifier())
                ->append($this->addNotifuNotifier())
                ->append($this->addNotifySendNotifier())
                ->append($this->addSnoreToastNotifier())
                ->append($this->addTerminalNotifierNotifier())
                ->append($this->addToasterNotifier())
                ->append($this->addZenityNotifier())
            ->end();

        return $rootNode;
    }

    /**
     * @return ArrayNodeDefinition
     */
    private function addGrowlNotifyNotifier()
    {
        $name = 'growl_notify';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('priority')
                    ->beforeNormalization()
                        ->always(function ($v) { return (int) $v; })
                    ->end()
                    ->defaultValue(0)
                ->end()
                ->scalarNode('binary')->defaultValue('growlnotify')->end()
                ->arrayNode('binary_paths')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('title')->defaultValue(null)->end()
                ->booleanNode('mute')->defaultValue(true)->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('scalar')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    /**
     * @return ArrayNodeDefinition
     */
    private function addKDialogNotifier()
    {
        $name = 'kdialog_notifier';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('priority')
                    ->beforeNormalization()
                        ->always(function ($v) { return (int) $v; })
                    ->end()
                    ->defaultValue(0)
                ->end()
                ->scalarNode('binary')->defaultValue('kdialog')->end()
                ->arrayNode('binary_paths')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('title')->defaultValue(null)->end()
                ->booleanNode('mute')->defaultValue(true)->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    /**
     * @return ArrayNodeDefinition
     */
    private function addNotifuNotifier()
    {
        $name = 'notifu_notifier';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('priority')
                    ->beforeNormalization()
                        ->always(function ($v) { return (int) $v; })
                    ->end()
                    ->defaultValue(0)
                ->end()
                ->scalarNode('binary')->defaultValue('notifu')->end()
                ->arrayNode('binary_paths')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('title')->defaultValue(null)->end()
                ->booleanNode('mute')->defaultValue(true)->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    /**
     * @return ArrayNodeDefinition
     */
    private function addNotifySendNotifier()
    {
        $name = 'notify_send';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('priority')
                    ->beforeNormalization()
                        ->always(function ($v) { return (int) $v; })
                    ->end()
                    ->defaultValue(2)
                ->end()
                ->scalarNode('binary')->defaultValue('notify-send')->end()
                ->arrayNode('binary_paths')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('title')->defaultValue(null)->end()
                ->booleanNode('mute')->defaultValue(true)->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    /**
     * @return ArrayNodeDefinition
     */
    private function addSnoreToastNotifier()
    {
        $name = 'snore_toast_notifier';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('priority')
                    ->beforeNormalization()
                        ->always(function ($v) { return (int) $v; })
                    ->end()
                    ->defaultValue(0)
                ->end()
                ->scalarNode('binary')->defaultValue('snoretoast')->end()
                ->arrayNode('binary_paths')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('title')->defaultValue(null)->end()
                ->booleanNode('mute')->defaultValue(true)->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    /**
     * @return ArrayNodeDefinition
     */
    private function addTerminalNotifierNotifier()
    {
        $name = 'terminal_notifier_notifier';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('priority')
                    ->beforeNormalization()
                        ->always(function ($v) { return (int) $v; })
                    ->end()
                    ->defaultValue(0)
                ->end()
                ->scalarNode('binary')->defaultValue('terminal-notifier')->end()
                ->arrayNode('binary_paths')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('title')->defaultValue(null)->end()
                ->booleanNode('mute')->defaultValue(true)->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    /**
     * @return ArrayNodeDefinition
     */
    private function addToasterNotifier()
    {
        $name = 'toaster';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('priority')
                    ->beforeNormalization()
                        ->always(function ($v) { return (int) $v; })
                    ->end()
                    ->defaultValue(0)
                ->end()
                ->scalarNode('binary')->defaultValue('toast')->end()
                ->arrayNode('binary_paths')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('title')->defaultValue(null)->end()
                ->booleanNode('mute')->defaultValue(true)->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $rootNode;
    }

        /**
     * @return ArrayNodeDefinition
     */
    private function addZenityNotifier()
    {
        $name = 'zenity';
        $rootNode = $this->getRootNode(new TreeBuilder($name), $name);

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('priority')
                    ->beforeNormalization()
                        ->always(function ($v) { return (int) $v; })
                    ->end()
                    ->defaultValue(1)
                ->end()
                ->scalarNode('binary')->defaultValue('zenity')->end()
                ->arrayNode('binary_paths')
                    ->beforeNormalization()
                    ->ifString()
                        ->then(function($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('title')->defaultValue(null)->end()
                ->booleanNode('mute')->defaultValue(true)->end()
                ->arrayNode('icons')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
                ->arrayNode('sounds')
                    ->prototype('variable')->end()
                    ->defaultValue(array())
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    private function getRootNode(TreeBuilder $treeBuilder, $name)
    {
        // BC layer for symfony/config 4.1 and older
        if (\method_exists($treeBuilder, 'getRootNode')) {
            return $treeBuilder->getRootNode();
        }

        return $treeBuilder->root($name);
    }
}
