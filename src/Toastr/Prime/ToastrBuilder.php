<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

/**
 * @method Toastr getNotification()
 */
final class ToastrBuilder extends NotificationBuilder
{
    /**
     * @param string $title
     *
     * @return self
     */
    public function title($title)
    {
        $notification = $this->envelope->getNotification();
        $notification->setTitle($title);

        return $this;
    }
}
