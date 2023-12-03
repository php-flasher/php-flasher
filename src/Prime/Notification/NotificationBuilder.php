<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\Macroable;

class NotificationBuilder implements NotificationBuilderInterface
{
    use Macroable;
    use NotificationBuilderMethods;
    use NotificationStorageMethods;

    public function __construct(string|NotificationInterface $notification, StorageManagerInterface $storageManager)
    {
        if (is_string($notification)) {
            $plugin = new PluginStamp($notification);

            $notification = Envelope::wrap(new Notification());
            $notification->withStamp($plugin);
        }

        $envelope = Envelope::wrap($notification);
        $envelope->withStamp(new PluginStamp('flasher'), false);

        $this->envelope = $envelope;
        $this->storageManager = $storageManager;
        $this->addMethodAliases();
    }

    private function addMethodAliases(): void
    {
        $methods = [
            'success',
            'error',
            'info',
            'warning',
            'flash',
            'preset',
            'created',
            'updated',
            'saved',
            'deleted',
            'operation',
        ];

        foreach ($methods as $method) {
            $this->methodAliases['add'.ucfirst($method)] = $method;
        }
    }
}
