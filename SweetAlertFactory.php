<?php

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Factory\AbstractFactory;

final class SweetAlertFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotification()
    {
        return new SweetAlert();
    }

    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new SweetAlertBuilder($this->getEventDispatcher(), $this->createNotification(), 'sweet_alert');
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'sweet_alert'));
    }
}
