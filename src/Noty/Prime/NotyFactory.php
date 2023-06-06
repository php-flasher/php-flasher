<?php

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\Notification;

/**
 * @mixin NotyBuilder
 */
final class NotyFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new NotyBuilder($this->getStorageManager(), new Notification(), 'noty');
    }
}
