<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin \Flasher\Toastr\Prime\ToastrBuilder
 */
final class Toastr extends NotificationFactory implements ToastrInterface
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new ToastrBuilder('toastr', $this->storageManager);
    }
}
