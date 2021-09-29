<?php

namespace Flasher\Cli\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class CliNotificationBuilder extends NotificationBuilder
{
    /**
     * @param string $title
     *
     * @return self
     */
    public function title($title)
    {
        $notification = $this->envelope->getNotification();
        $notification->setTitle(addslashes($title));

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return self
     */
    public function icon($icon)
    {
        $notification = $this->envelope->getNotification();
        $notification->setIcon($icon);

        return $this;
    }
}
