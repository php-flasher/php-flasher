<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\FlasherBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin \Flasher\Prime\Notification\FlasherBuilder
 */
final class FlasherFactory extends NotificationFactory implements FlasherFactoryInterface
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new FlasherBuilder('flasher', $this->storageManager);
    }
}
