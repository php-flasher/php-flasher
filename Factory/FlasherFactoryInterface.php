<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotificationBuilderInterface
 */
interface FlasherFactoryInterface
{
    /**
     * @return NotificationBuilderInterface
     */
    public function createNotificationBuilder();
}
