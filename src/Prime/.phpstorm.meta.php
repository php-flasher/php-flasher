<?php

namespace PHPSTORM_META;

registerArgumentsSet('notificationTypes', NotificationInterface::TYPE_SUCCESS, NotificationInterface::TYPE_ERROR, NotificationInterface::TYPE_WARNING, NotificationInterface::TYPE_INFO);

override(Envelope::get(0), type(0));

expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::type(), 0, argumentsSet('notificationTypes'));
expectedArguments(\Flasher\Prime\Notification\NotificationBuilderInterface::addFlash(), 0, argumentsSet('notificationTypes'));
expectedArguments(\Flasher\Prime\Notification\NotificationInterface::setType(), 0, argumentsSet('notificationTypes'));

expectedReturnValues(\Flasher\Prime\Notification\NotificationInterface::getType(), argumentsSet('notificationTypes'));

override(\Flasher\Prime\FlasherInterface::create(), map([
    '' => '@',
    'template' => \Flasher\Prime\Factory\TemplateFactory::class,
    'template.tailwindcss' => \Flasher\Prime\Factory\TemplateFactory::class,
    'template.tailwindcss_bg' => \Flasher\Prime\Factory\TemplateFactory::class,
    'template.bootstrap' => \Flasher\Prime\Factory\TemplateFactory::class,
]));

override(\Flasher\Prime\FlasherInterface::using(), map([
    '' => '@',
    'template' => \Flasher\Prime\Factory\TemplateFactory::class,
    'template.tailwindcss' => \Flasher\Prime\Factory\TemplateFactory::class,
    'template.tailwindcss_bg' => \Flasher\Prime\Factory\TemplateFactory::class,
    'template.bootstrap' => \Flasher\Prime\Factory\TemplateFactory::class,
]));
