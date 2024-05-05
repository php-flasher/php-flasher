<?php

namespace PHPSTORM_META;

override(Envelope::get(0), type(0));

override(\Flasher\Prime\FlasherInterface::create(), map(['flasher' => \Flasher\Prime\Factory\FlasherFactory::class, 'theme.' => \Flasher\Prime\Factory\FlasherFactory::class]));
override(\Flasher\Prime\Container\FlasherContainer::create(), map(['flasher' => \Flasher\Prime\Factory\FlasherFactory::class, 'theme.' => \Flasher\Prime\Factory\FlasherFactory::class]));
override(\Flasher\Prime\FlasherInterface::use(), map(['flasher' => \Flasher\Prime\Factory\FlasherFactory::class, 'theme.' => \Flasher\Prime\Factory\FlasherFactory::class]));

registerArgumentsSet('types', 'success', 'error', 'warning', 'info');
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::type(), 0, argumentsSet('types'));
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::addFlash(), 0, argumentsSet('types'));
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::flash(), 0, argumentsSet('types'));
expectedArguments(\Flasher\Prime\Notification\NotificationInterface::setType(), 0, argumentsSet('types'));
expectedArguments(flash(), 1, argumentsSet('types'));
expectedArguments(\Flasher\Prime\flash(), 1, argumentsSet('types'));
expectedReturnValues(\Flasher\Prime\Notification\NotificationInterface::getType(), argumentsSet('types'));

expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::handler(), 0, 'flasher', 'toastr', 'noty', 'notyf', 'sweetalert');

expectedArguments(\Flasher\Prime\FlasherInterface::render(), 0, 'html', 'json', 'array');
