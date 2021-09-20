<?php

use Symfony\Component\DependencyInjection\Reference;

$container
    ->register('flasher.console', 'Flasher\Console\Prime\FlasherConsole')
    ->addArgument(new Reference('flasher.storage_manager'))
    ->addArgument(new Reference('flasher.event_dispatcher'))
    ->addArgument(array());

$container
    ->register('flasher.event_listener.render_listener', 'Flasher\Console\Prime\EventListener\RenderListener')
    ->addArgument(new Reference('flasher.console'))
    ->addTag('flasher.event_subscriber', array('priority' => -256));

$container
    ->register('flasher.console.notify_send', 'Flasher\Console\Prime\Notifier\NotifySendNotifier')
    ->addArgument(array())
    ->addTag('flasher.console_notifier');
