<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * @mixin \Flasher\Toastr\Prime\ToastrBuilder
 */
final class Toastr extends NotificationFactory implements ToastrInterface
{
    public function createNotificationBuilder(): ToastrBuilder
    {
        return new ToastrBuilder('toastr', $this->storageManager);
    }
}
