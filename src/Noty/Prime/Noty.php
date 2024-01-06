<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin \Flasher\Noty\Prime\NotyBuilder
 */
final class Noty extends NotificationFactory implements NotyInterface
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new NotyBuilder('noty', $this->storageManager);
    }
}
