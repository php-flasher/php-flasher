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
    ->setClass('Flasher\SweetAlert\Prime\SweetAlertFactory')
    ->addTag('flasher.factory', array('alias' => 'sweet_alert'));

$container->setDefinition('flasher.sweet_alert', $definition);

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\SweetAlert\Prime\SweetAlertFactory', 'flasher.sweet_alert');
}
