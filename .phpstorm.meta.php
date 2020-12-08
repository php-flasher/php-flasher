<?php

namespace PHPSTORM_META;

use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Notification\NotificationInterface;

registerArgumentsSet('notificationTypes', NotificationInterface::TYPE_SUCCESS, NotificationInterface::TYPE_ERROR, NotificationInterface::TYPE_WARNING, NotificationInterface::TYPE_INFO);

override(Envelope::get(0), type(0));

expectedArguments(NotificationBuilderInterface::type(), 1, argumentsSet('notificationTypes'));
expectedArguments(NotificationBuilderInterface::addFlash(), 1, argumentsSet('notificationTypes'));
expectedArguments(NotificationInterface::setType(), 1, argumentsSet('notificationTypes'));

expectedReturnValues(NotificationInterface::getType(), argumentsSet('notificationTypes'));
