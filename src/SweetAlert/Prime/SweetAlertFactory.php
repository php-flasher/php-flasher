<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin SweetAlertBuilder
 */
final class SweetAlertFactory extends NotificationFactory
{
    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new SweetAlertBuilder('sweetalert', $this->storageManager);
    }
}
