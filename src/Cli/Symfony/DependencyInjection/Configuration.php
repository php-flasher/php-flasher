<?php

namespace Flasher\Cli\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flasher_cli');
        $rootNode = $this->getRootNode($treeBuilder, 'flasher_cli');

        $rootNode
            ->children()
                ->booleanNode('render_all')
                    ->defaultValue(false)
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
                ->append($this->addNotifiersConfig())
            ->end()
        ;

        return $treeBuilder;
    }

    private function addNotifiersConfig()
    {
        $treeBuilder = new TreeBuilder('notifiers');
        $rootNode = $this->getRootNode($treeBuilder, 'notifiers');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->append($this->addGrowlNotifyNotifier())
                ->append($this->addKDialogNotifier())
                ->append($this->addNotifuNotifier())
                ->append($this->addNotifySendNotifier())
                ->append($this->addSnoreToastNotifier())
                ->append($this->addTerminalNotifierNotifier())
                ->append($this->addToasterNotifier())
            ->end();

        return $rootNode;
    }

    /**
     * @return ArrayNodeDefinition
     */
    private function addGrowlNotifyNotifier()
    {
        $treeBuilder = new TreeBuilder('growl_notify');
        $rootNode = $this->getRootNode($treeBuilder, 'growl_notify');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('service')->defaultValue('flasher.cli.growl_notify')->end()
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
                    ->prototype('scalar')->end()
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
        $treeBuilder = new TreeBuilder('kdialog_notifier');
        $rootNode = $this->getRootNode($treeBuilder, 'kdialog_notifier');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('service')->defaultValue('flasher.cli.kdialog_notifier')->end()
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
                    ->prototype('scalar')->end()
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
    private function addNotifuNotifier()
    {
        $treeBuilder = new TreeBuilder('notifu_notifier');
        $rootNode = $this->getRootNode($treeBuilder, 'notifu_notifier');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('service')->defaultValue('flasher.cli.notifu_notifier')->end()
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
                    ->prototype('scalar')->end()
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
    private function addNotifySendNotifier()
    {
        $treeBuilder = new TreeBuilder('notify_send');
        $rootNode = $this->getRootNode($treeBuilder, 'notify_send');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('service')->defaultValue('flasher.cli.notify_send')->end()
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
                    ->prototype('scalar')->end()
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
    private function addSnoreToastNotifier()
    {
        $treeBuilder = new TreeBuilder('snore_toast_notifier');
        $rootNode = $this->getRootNode($treeBuilder, 'snore_toast_notifier');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('service')->defaultValue('flasher.cli.snore_toast_notifier')->end()
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
                    ->prototype('scalar')->end()
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
    private function addTerminalNotifierNotifier()
    {
        $treeBuilder = new TreeBuilder('terminal_notifier_notifier');
        $rootNode = $this->getRootNode($treeBuilder, 'terminal_notifier_notifier');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('service')->defaultValue('flasher.cli.terminal_notifier_notifier')->end()
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
                    ->prototype('scalar')->end()
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
    private function addToasterNotifier()
    {
        $treeBuilder = new TreeBuilder('toaster_send');
        $rootNode = $this->getRootNode($treeBuilder, 'toaster_send');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')->defaultValue(true)->end()
                ->scalarNode('service')->defaultValue('flasher.cli.toaster_send')->end()
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
                    ->prototype('scalar')->end()
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

    private function getRootNode(TreeBuilder $treeBuilder, $name)
    {
        // BC layer for symfony/config 4.1 and older
        if (\method_exists($treeBuilder, 'getRootNode')) {
            return $treeBuilder->getRootNode();
        }

        return $treeBuilder->root($name);
    }
}
