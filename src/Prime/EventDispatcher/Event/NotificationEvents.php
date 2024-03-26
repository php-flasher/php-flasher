<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\NotificationInterface;

final class NotificationEvents
{
    /** @var NotificationInterface[] */
    private array $notifications = [];

    public function add(NotificationInterface ...$notifications): void
    {
        foreach ($notifications as $notification) {
            $this->addNotification($notification);
        }
    }

    public function addNotification(NotificationInterface $notification): void
    {
        $this->notifications[] = $notification;
    }

    /**
     * @return NotificationInterface[]
     */
    public function getNotifications(): array
    {
        return $this->notifications;
    }
}
