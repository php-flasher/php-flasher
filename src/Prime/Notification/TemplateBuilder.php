<?php

namespace Flasher\Prime\Notification;

final class TemplateBuilder extends NotificationBuilder
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
