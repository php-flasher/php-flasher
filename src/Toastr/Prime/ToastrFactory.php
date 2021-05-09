<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * @mixin ToastrBuilder
 */
final class ToastrFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new ToastrBuilder($this->getStorageManager(), new Toastr(), 'toastr');
    }
}
