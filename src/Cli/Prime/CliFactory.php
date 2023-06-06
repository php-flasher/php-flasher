<?php

namespace Flasher\Cli\Prime;

use Flasher\Prime\Factory\NotificationFactory;

final class CliFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new CliBuilder($this->getStorageManager(), new Notification(), 'cli');
    }
}
