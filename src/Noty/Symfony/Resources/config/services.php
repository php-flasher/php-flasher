<?php

use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Flasher\Symfony\Bridge\Bridge;

if (class_exists('Symfony\Component\DependencyInjection\ChildDefinition')) {
    $definition = new ChildDefinition('flasher.notification_factory');
} else {
    $definition = new DefinitionDecorator('flasher.notification_factory');
}

$definition
    ->setClass('Flasher\Noty\Prime\NotyFactory')
    ->addTag('flasher.factory', array('alias' => 'noty'));

$container->setDefinition('flasher.noty', $definition);

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Noty\Prime\NotyFactory', 'flasher.noty');
}
