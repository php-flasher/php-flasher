<?php

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Factory\AbstractFactory;

final class PnotifyFactory extends AbstractFactory
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
        return new PnotifyBuilder($this->getEventDispatcher(), $this->createNotification(), 'pnotify');
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'pnotify'));
    }
}
