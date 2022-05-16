<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\Notification;

/**
 * @mixin PnotifyBuilder
 */
final class PnotifyFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new PnotifyBuilder($this->getStorageManager(), new Notification(), 'pnotify');
    }
}
