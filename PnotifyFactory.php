<?php

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * @mixin PnotifyBuilder
 */
final class PnotifyFactory extends NotificationFactory
{
    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new PnotifyBuilder($this->getStorageManager(), new Pnotify(), 'pnotify');
    }
}
