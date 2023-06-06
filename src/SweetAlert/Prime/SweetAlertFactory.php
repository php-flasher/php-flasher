<?php

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\Notification;

/**
 * @mixin SweetAlertBuilder
 */
final class SweetAlertFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new SweetAlertBuilder($this->getStorageManager(), new Notification(), 'sweetalert');
    }
}
