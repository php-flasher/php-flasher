<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\AbstractFactory;

final class ToastrFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotification()
    {
        return new Toastr();
    }

    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new ToastrBuilder($this->getEventDispatcher(), $this->createNotification(), 'toastr');
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'toastr'));
    }
}
