<?php

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * @mixin SweetAlertBuilder
 */
final class SweetAlertFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new SweetAlertBuilder($this->getStorageManager(), new SweetAlert(), 'sweet_alert');
    }
}
