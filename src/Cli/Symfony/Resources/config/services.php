<?php

use Flasher\Cli\Prime\Presenter\CliPresenter;
use Flasher\Symfony\Bridge\Bridge;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

if (!isset($container)) {
    return;
}

/** @var ChildDefinition $definition */
$definition = class_exists('Symfony\Component\DependencyInjection\ChildDefinition')
    ? new ChildDefinition('flasher.notification_factory')
    : new DefinitionDecorator('flasher.notification_factory'); // @phpstan-ignore-line

$definition
    ->setClass('Flasher\Cli\Prime\CliFactory')
    ->setPublic(true)
    ->addTag('flasher.factory', ['alias' => 'cli']);

$container->setDefinition('flasher.cli', $definition);

$container->register('flasher.notify', 'Flasher\Cli\Prime\Notify')
    ->setPublic(true)
    ->addArgument(null)
    ->addArgument([]);

$container
    ->register('flasher.cli.presenter', 'Flasher\Cli\Prime\Presenter\CliPresenter')
    ->addArgument(new Reference('flasher.notify'))
    ->addTag('flasher.presenter', ['alias' => CliPresenter::NAME]);

$container
    ->register('flasher.cli.render_listener', 'Flasher\Cli\Prime\EventListener\RenderListener')
    ->addArgument(new Reference('flasher'))
    ->addTag('flasher.event_subscriber', ['priority' => -256]);

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Cli\Prime\CliFactory', 'flasher.cli');
    $container->setAlias('Flasher\Cli\Prime\Notify', 'flasher.notify');
    $container->setAlias('Flasher\Cli\Prime\NotifyInterface', 'flasher.notify');
}
