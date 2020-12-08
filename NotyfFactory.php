<?php

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Factory\AbstractFactory;

final class NotyfFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotification()
    {
        return new Pnotify();
    }

    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new PnotifyBuilder($this->getStorageManager(), $this->createNotification(), 'notyf');
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'notyf'));
    }
}
