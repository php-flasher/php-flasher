<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\Notification;

/**
 * @mixin NotyBuilder
 */
final class NotyFactory extends NotificationFactory
{
    public function createNotificationBuilder(): \Flasher\Prime\Notification\NotificationBuilderInterface
    {
        return new NotyBuilder($this->getStorageManager(), new Notification(), 'noty');
    }
}
