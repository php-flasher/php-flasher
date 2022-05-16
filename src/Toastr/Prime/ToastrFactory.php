<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\Notification;

/**
 * @mixin ToastrBuilder
 */
final class ToastrFactory extends NotificationFactory
{
    /**
     * {@inheritdoc}
     */
    public function createNotificationBuilder()
    {
        return new ToastrBuilder($this->getStorageManager(), new Notification(), 'toastr');
    }
}
