<?php

use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Flasher\Symfony\Bridge\Bridge;
use Symfony\Component\DependencyInjection\Reference;

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
    ->register('flasher.event_listener.cli_stamps_listener', 'Flasher\Cli\Prime\EventListener\StampsListener')
    ->addArgument(false)
    ->addArgument(true)
    ->addTag('flasher.event_subscriber');

$container
    ->register('flasher.event_listener.cli_render_listener', 'Flasher\Cli\Prime\EventListener\RenderListener')
    ->addArgument(new Reference('flasher'))
    ->addTag('flasher.event_subscriber', array('priority' => -256));

$container
    ->register('flasher.cli.growl_notify', 'Flasher\Cli\Prime\Notifier\GrowlNotifyNotifier')
    ->addArgument(array())
    ->addTag('flasher.cli_notifier');

$container
    ->register('flasher.cli.kdialog_notifier', 'Flasher\Cli\Prime\Notifier\KDialogNotifier')
    ->addArgument(array())
    ->addTag('flasher.cli_notifier');

$container
    ->register('flasher.cli.notifu_notifier', 'Flasher\Cli\Prime\Notifier\NotifuNotifier')
    ->addArgument(array())
    ->addTag('flasher.cli_notifier');

$container
    ->register('flasher.cli.notify_send', 'Flasher\Cli\Prime\Notifier\NotifySendNotifier')
    ->addArgument(array())
    ->addTag('flasher.cli_notifier');

$container
    ->register('flasher.cli.snore_toast_notifier', 'Flasher\Cli\Prime\Notifier\SnoreToastNotifier')
    ->addArgument(array())
    ->addTag('flasher.cli_notifier');

$container
    ->register('flasher.cli.terminal_notifier_notifier', 'Flasher\Cli\Prime\Notifier\TerminalNotifierNotifier')
    ->addArgument(array())
    ->addTag('flasher.cli_notifier');

$container
    ->register('flasher.cli.toaster_send', 'Flasher\Cli\Prime\Notifier\ToasterNotifier')
    ->addArgument(array())
    ->addTag('flasher.cli_notifier');

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Cli\Prime\CliNotificationFactory', 'flasher.cli');
}
