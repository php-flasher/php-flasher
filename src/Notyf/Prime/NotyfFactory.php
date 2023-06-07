<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\Notification;

/**
 * @mixin NotyfBuilder
 */
final class NotyfFactory extends NotificationFactory
{
    public function createNotificationBuilder(): \Flasher\Prime\Notification\NotificationBuilderInterface
    {
        return new NotyfBuilder($this->getStorageManager(), new Notification(), 'notyf');
    }
}
