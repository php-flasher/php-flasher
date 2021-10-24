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

        if (!$notification instanceof Template) {
            return $this;
        }

        $notification->setTitle($title);

        return $this;
    }
}
