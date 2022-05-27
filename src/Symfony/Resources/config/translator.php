<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Symfony\Component\DependencyInjection\Reference;

if (!isset($container)) {
    return;
}

$container->register('flasher.translator', 'Flasher\Symfony\Translation\Translator')
    ->setPublic(false)
    ->addArgument(new Reference('translator'));

$container->register('flasher.translation_listener', 'Flasher\Prime\EventDispatcher\EventListener\TranslationListener')
    ->setPublic(false)
    ->addArgument(new Reference('flasher.translator'))
    ->addArgument(true)
    ->addTag('flasher.event_subscriber');
