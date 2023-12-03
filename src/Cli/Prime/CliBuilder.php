<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class CliBuilder extends NotificationBuilder
{
    public $envelope;

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
     * @return static
     */
    public function icon(?string $icon)
    {
        /** @var Notification $notification */
        $notification = $this->envelope->getNotification();
        $notification->setIcon($icon);

        return $this;
    }
}
