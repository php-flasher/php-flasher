<?php

namespace PHPSTORM_META;

override(Envelope::get(0), type(0));

override(\Flasher\Prime\FlasherInterface::create(), map([
    'flasher' => \Flasher\Prime\Factory\NotificationFactory::class,
    'theme.' => \Flasher\Prime\Factory\NotificationFactory::class,
]));

override(\Flasher\Prime\FlasherInterface::using(), map([
    'flasher' => \Flasher\Prime\Factory\NotificationFactory::class,
    'theme.' => \Flasher\Prime\Factory\NotificationFactory::class,
]));

registerArgumentsSet('types', 'success', 'error', 'warning', 'info');
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::type(), 0, argumentsSet('types'));
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::addFlash(), 0, argumentsSet('types'));
expectedArguments(\Flasher\Prime\Notification\NotificationInterface::setType(), 0, argumentsSet('types'));
expectedReturnValues(\Flasher\Prime\Notification\NotificationInterface::getType(), argumentsSet('types'));


expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::handler(), 0, 'flasher', 'toastr', 'noty', 'notyf', 'pnotify', 'sweetalert');
