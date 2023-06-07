<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime;

use Flasher\Prime\Factory\NotificationFactory;

final class CliFactory extends NotificationFactory
{
    public function createNotificationBuilder(): \Flasher\Prime\Notification\NotificationBuilderInterface
    {
        return new CliBuilder($this->getStorageManager(), new Notification(), 'cli');
    }
}
