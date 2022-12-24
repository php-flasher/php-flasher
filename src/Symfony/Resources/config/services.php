<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Flasher\Symfony\Bridge\Bridge;
use Symfony\Component\DependencyInjection\Reference;

if (!isset($container)) {
    return;
}

$container->register('flasher.config', 'Flasher\Prime\Config\Config')
    ->setPublic(false)
    ->addArgument(array());

$storage = Bridge::versionCompare('5.3', '>=')
    ? new Reference('request_stack')
    : new Reference('session');

$container->register('flasher.storage_bag', 'Flasher\Symfony\Storage\SessionBag')
    ->setPublic(false)
    ->addArgument($storage);

$container->register('flasher.storage', 'Flasher\Prime\Storage\StorageBag')
    ->setPublic(false)
    ->addArgument(new Reference('flasher.storage_bag'));

$container->register('flasher.event_dispatcher', 'Flasher\Prime\EventDispatcher\EventDispatcher')
    ->setPublic(false);

$container->register('flasher.storage_manager', 'Flasher\Prime\Storage\StorageManager')
    ->setPublic(false)
    ->addArgument(new Reference('flasher.storage'))
    ->addArgument(new Reference('flasher.event_dispatcher'))
    ->addArgument(array());

$container->register('flasher.twig.extension', 'Flasher\Symfony\Twig\FlasherTwigExtension')
    ->setPublic(false)
    ->addTag('twig.extension', array());

$container->register('flasher.template_engine', 'Flasher\Symfony\Template\TwigTemplateEngine')
    ->setPublic(false)
    ->addArgument(new Reference('twig'));

$container->register('flasher.resource_manager', 'Flasher\Prime\Response\Resource\ResourceManager')
    ->setPublic(false)
    ->addArgument(new Reference('flasher.config'))
    ->addArgument(new Reference('flasher.template_engine'));

$container->register('flasher.response_manager', 'Flasher\Prime\Response\ResponseManager')
    ->setPublic(false)
    ->addArgument(new Reference('flasher.resource_manager'))
    ->addArgument(new Reference('flasher.storage_manager'))
    ->addArgument(new Reference('flasher.event_dispatcher'));

$container->register('flasher', 'Flasher\Prime\Flasher')
    ->setPublic(true)
    ->addArgument(null)
    ->addArgument(new Reference('flasher.response_manager'))
    ->addArgument(new Reference('flasher.storage_manager'));

$container->register('flasher.notification_factory', 'Flasher\Prime\Factory\NotificationFactory')
    ->setPublic(false)
    ->addArgument(new Reference('flasher.storage_manager'));

$container->register('flasher.translator', 'Flasher\Symfony\Translation\Translator')
    ->setPublic(false)
    ->addArgument(new Reference('translator'));

$container->register('flasher.translation_listener', 'Flasher\Prime\EventDispatcher\EventListener\TranslationListener')
    ->setPublic(false)
    ->addArgument(new Reference('flasher.translator'))
    ->addArgument(true)
    ->addTag('flasher.event_subscriber');

$container->register('flasher.preset_listener', 'Flasher\Prime\EventDispatcher\EventListener\PresetListener')
    ->setPublic(false)
    ->addArgument(array())
    ->addTag('flasher.event_subscriber');

$container->register('flasher.install_command', 'Flasher\Symfony\Command\InstallCommand')
    ->addTag('console.command');

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Prime\Flasher', 'flasher');
    $container->setAlias('Flasher\Prime\FlasherInterface', 'flasher');
}
