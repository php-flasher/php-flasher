<?php

declare(strict_types=1);

namespace Flasher\Cli\Symfony\Resources\config;

use Symfony\Component\DependencyInjection\ChildDefinition;

if (!isset($container)) {
    return;
}

/** @var ChildDefinition $definition */
$definition = \class_exists(\Symfony\Component\DependencyInjection\ChildDefinition::class)
    ? new \Symfony\Component\DependencyInjection\ChildDefinition('flasher.notification_factory')
    : new \Symfony\Component\DependencyInjection\DefinitionDecorator('flasher.notification_factory');
// @phpstan-ignore-line
$definition
    ->setClass(\Flasher\Cli\Prime\CliFactory::class)
    ->setPublic(true)
    ->addTag('flasher.factory', ['alias' => 'cli']);
$container->setDefinition('flasher.cli', $definition);
$container->register('flasher.notify', \Flasher\Cli\Prime\Notify::class)
    ->setPublic(true)
    ->addArgument(null)
    ->addArgument([]);
$container
    ->register('flasher.cli.presenter', \Flasher\Cli\Prime\Presenter\CliPresenter::class)
    ->addArgument(new \Symfony\Component\DependencyInjection\Reference('flasher.notify'))
    ->addTag('flasher.presenter', ['alias' => \Flasher\Cli\Prime\Presenter\CliPresenter::NAME]);
$container
    ->register('flasher.cli.render_listener', \Flasher\Cli\Prime\EventListener\RenderListener::class)
    ->addArgument(new \Symfony\Component\DependencyInjection\Reference('flasher'))
    ->addTag('flasher.event_subscriber', ['priority' => -256]);
if (\Flasher\Symfony\Bridge\Bridge::canLoadAliases()) {
    $container->setAlias(\Flasher\Cli\Prime\CliFactory::class, 'flasher.cli');
    $container->setAlias(\Flasher\Cli\Prime\Notify::class, 'flasher.notify');
    $container->setAlias(\Flasher\Cli\Prime\NotifyInterface::class, 'flasher.notify');
}
