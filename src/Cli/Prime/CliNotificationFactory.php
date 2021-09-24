<?php

namespace Flasher\Cli\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * @mixin CliNotificationBuilder
 */
final class CliNotificationFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new CliNotificationBuilder($this->getStorageManager(), new CliNotification(), 'cli');
    }
}
