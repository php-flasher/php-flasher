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
    ->setClass('Flasher\Pnotify\Prime\PnotifyFactory')
    ->addTag('flasher.factory', array('alias' => 'pnotify'));

$container->setDefinition('flasher.pnotify', $definition);

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Pnotify\Prime\PnotifyFactory', 'flasher.pnotify');
}
