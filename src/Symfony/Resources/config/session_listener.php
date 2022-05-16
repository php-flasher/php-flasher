<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

use Symfony\Component\DependencyInjection\Reference;

if (!isset($container)) {
    return;
}

$container->register('flasher.session_listener', 'Flasher\Symfony\EventListener\SessionListener')
    ->setPublic(false)
    ->addArgument(new Reference('flasher'))
    ->addArgument(array())
    ->addTag('kernel.event_listener', array('event' => 'kernel.response'));
