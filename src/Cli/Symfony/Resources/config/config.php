<?php

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Flasher\Symfony\Bridge\Bridge;

if (class_exists('Symfony\Component\DependencyInjection\ChildDefinition')) {
    $definition = new ChildDefinition('flasher.notification_factory');
} else {
    $definition = new DefinitionDecorator('flasher.notification_factory');
}

$definition
    ->setClass('Flasher\Cli\Prime\CliNotificationFactory')
    ->addTag('flasher.factory', array('alias' => 'cli'));

$container->setDefinition('flasher.cli', $definition);

$container
    ->register('flasher.presenter.cli', 'Flasher\Cli\Prime\Presenter\CliPresenter')
    ->addTag('flasher.presenter', array('alias' => 'cli'));

$container
    ->register('flasher.console.notify_send', 'Flasher\Console\Prime\Notifier\NotifySendNotifier')
    ->addArgument(array())
    ->addTag('flasher.console_notifier');

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Cli\Prime\CliNotificationFactory', 'flasher.cli');
}
