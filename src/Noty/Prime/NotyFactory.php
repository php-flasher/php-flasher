<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotyBuilder
 */
final class NotyFactory extends NotificationFactory
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new NotyBuilder('noty', $this->storageManager);
    }
}
