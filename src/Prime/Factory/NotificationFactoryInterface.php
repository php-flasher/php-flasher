<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
