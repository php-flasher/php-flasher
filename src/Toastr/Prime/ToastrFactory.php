<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin ToastrBuilder
 */
final class ToastrFactory extends NotificationFactory
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new ToastrBuilder('toastr', $this->storageManager);
    }
}
