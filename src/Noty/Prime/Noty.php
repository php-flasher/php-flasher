<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * @mixin \Flasher\Noty\Prime\NotyBuilder
 */
final class Noty extends NotificationFactory implements NotyInterface
{
    public function createNotificationBuilder(): NotyBuilder
    {
        return new NotyBuilder('noty', $this->storageManager);
    }
}
