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
    ->setClass('Flasher\Toastr\Prime\ToastrFactory')
    ->addTag('flasher.factory', array('alias' => 'toastr'));

$container->setDefinition('flasher.toastr', $definition);

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Toastr\Prime\ToastrFactory', 'flasher.toastr');
}
