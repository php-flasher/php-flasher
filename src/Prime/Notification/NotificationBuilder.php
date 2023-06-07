<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\Macroable;

final class NotificationBuilder
{
    use NotificationBuilderMethods;
    use NotificationStorageMethods;
    use Macroable;

    private readonly Envelope $envelope;
    private readonly StorageManagerInterface $storageManager;

    public function __construct(NotificationInterface $notification, StorageManagerInterface $storageManager)
    {
        $this->envelope = Envelope::wrap($notification);
        $this->storageManager = $storageManager;
    }
}
