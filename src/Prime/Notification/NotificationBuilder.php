<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\Macroable;

class NotificationBuilder implements NotificationBuilderInterface
{
    use NotificationBuilderMethods;
    use NotificationStorageMethods;
    use Macroable;

    public function __construct(NotificationInterface $notification, StorageManagerInterface $storageManager)
    {
        $this->envelope = Envelope::wrap($notification);
        $this->storageManager = $storageManager;
    }
}
