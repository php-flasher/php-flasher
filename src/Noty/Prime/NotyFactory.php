<?php

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * @mixin NotyBuilder
 */
final class NotyFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new NotyBuilder($this->getStorageManager(), new Noty(), 'noty');
    }
}
