<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotificationBuilderInterface
 */
interface NotificationFactoryInterface
{
    public function createNotificationBuilder(): NotificationBuilderInterface;
}
