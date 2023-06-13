<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotyfBuilder
 */
final class NotyfFactory extends NotificationFactory
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new NotyfBuilder('notyf', $this->storageManager);
    }
}
