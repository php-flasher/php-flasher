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
    ->setClass('Flasher\Notyf\Prime\NotyfFactory')
    ->addTag('flasher.factory', array('alias' => 'notyf'));

$container->setDefinition('flasher.notyf', $definition);


if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Notyf\Prime\NotyfFactory', 'flasher.notyf');
}
