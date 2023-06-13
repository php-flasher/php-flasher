<?php

declare(strict_types=1);

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin PnotifyBuilder
 */
final class PnotifyFactory extends NotificationFactory
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new PnotifyBuilder('pnotify', $this->storageManager);
    }
}
