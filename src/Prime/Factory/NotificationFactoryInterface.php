<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotificationBuilderInterface
 */
interface NotificationFactoryInterface
{
    /**
     * @return NotificationBuilderInterface
     */
    public function createNotificationBuilder();
}
