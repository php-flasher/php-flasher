<?php

declare(strict_types=1);

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
    public function createNotificationBuilder(): \Flasher\Prime\Notification\NotificationBuilderInterface
    {
        return new PnotifyBuilder($this->getStorageManager(), new Notification(), 'pnotify');
    }
}
