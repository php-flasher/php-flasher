<?php

namespace PHPSTORM_META;

use Flasher\Prime\Notification\NotificationInterface;

registerArgumentsSet('notificationTypes', NotificationInterface::SUCCESS, NotificationInterface::ERROR, NotificationInterface::WARNING, NotificationInterface::INFO);

override(Envelope::get(0), type(0));

expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::type(), 0, argumentsSet('notificationTypes'));
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::addFlash(), 0, argumentsSet('notificationTypes'));
expectedArguments(\Flasher\Prime\Notification\NotificationInterface::setType(), 0, argumentsSet('notificationTypes'));

expectedReturnValues(\Flasher\Prime\Notification\NotificationInterface::getType(), argumentsSet('notificationTypes'));

override(\Flasher\Prime\FlasherInterface::create(), map([
    '' => '@',
    'flasher' => \Flasher\Prime\Factory\FlasherFactory::class,
    'theme.*' => \Flasher\Prime\Factory\FlasherFactory::class,
]));

override(\Flasher\Prime\FlasherInterface::using(), map([
    '' => '@',
    'flasher' => \Flasher\Prime\Factory\FlasherFactory::class,
    'theme.*' => \Flasher\Prime\Factory\FlasherFactory::class,
]));
