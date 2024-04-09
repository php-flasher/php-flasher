<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin \Flasher\Prime\Notification\NotificationBuilderInterface
 */
interface NotificationFactoryInterface
{
    public function createNotificationBuilder(): NotificationBuilderInterface;
}
