<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Notification\NotificationInterface;

interface FlasherFactoryInterface
{
    /**
     * @return NotificationBuilderInterface
     */
    public function createNotificationBuilder();

    /**
     * @return NotificationInterface
     */
    public function createNotification();

    /**
     * @param string $name
     * @param array $context
     *
     * @return bool
     */
    public function supports($name = null, array $context = array());
}
