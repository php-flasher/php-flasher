<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin \Flasher\Notyf\Prime\NotyfBuilder
 */
final class Notyf extends NotificationFactory implements NotyfInterface
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new NotyfBuilder('notyf', $this->storageManager);
    }
}
