<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class CliBuilder extends NotificationBuilder
{
    /**
     * @param string $title
     *
     * @return static
     */
    public function title($title)
    {
        /** @var Notification $notification */
        $notification = $this->envelope->getNotification();
        $notification->setTitle($title);

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return static
     */
    public function icon($icon)
    {
        /** @var Notification $notification */
        $notification = $this->envelope->getNotification();
        $notification->setIcon($icon);

        return $this;
    }
}
