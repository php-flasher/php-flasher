<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Prime;

use Flasher\Prime\Factory\NotificationFactory;

final class CliFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new CliBuilder($this->getStorageManager(), new Notification(), 'cli');
    }
}
