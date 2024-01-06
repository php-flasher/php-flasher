<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin \Flasher\SweetAlert\Prime\SweetAlertBuilder
 */
final class SweetAlert extends NotificationFactory implements SweetAlertInterface
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new SweetAlertBuilder('sweetalert', $this->storageManager);
    }
}
