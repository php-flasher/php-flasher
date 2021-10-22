<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\Notification;

/**
 * @mixin ToastrBuilder
 */
final class ToastrFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new ToastrBuilder($this->getStorageManager(), new Notification(), 'toastr');
    }
}
