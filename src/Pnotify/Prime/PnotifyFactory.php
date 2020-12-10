<?php

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Factory\AbstractFactory;

/**
 * @mixin PnotifyBuilder
 */
final class PnotifyFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new PnotifyBuilder($this->getStorageManager(), new Pnotify(), 'pnotify');
    }
}
