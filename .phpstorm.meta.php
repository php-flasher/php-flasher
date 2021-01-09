<?php

namespace PHPSTORM_META;

registerArgumentsSet('notificationTypes', NotificationInterface::TYPE_SUCCESS, NotificationInterface::TYPE_ERROR, NotificationInterface::TYPE_WARNING, NotificationInterface::TYPE_INFO);

override(Envelope::get(0), type(0));

expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::type(), 0, argumentsSet('notificationTypes'));
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::addFlash(), 0, argumentsSet('notificationTypes'));
expectedArguments(\Flasher\Prime\Notification\NotificationInterface::setType(), 0, argumentsSet('notificationTypes'));

expectedReturnValues(\Flasher\Prime\Notification\NotificationInterface::getType(), argumentsSet('notificationTypes'));
