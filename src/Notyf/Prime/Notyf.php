<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * @mixin \Flasher\Notyf\Prime\NotyfBuilder
 */
final class Notyf extends NotificationFactory implements NotyfInterface
{
    public function createNotificationBuilder(): NotyfBuilder
    {
        return new NotyfBuilder('notyf', $this->storageManager);
    }
}
