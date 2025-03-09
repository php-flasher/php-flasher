<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\Macroable;

/**
 * Base abstract class for notification builders.
 *
 * This abstract class provides the foundation for all notification builders,
 * implementing common functionality through traits. It manages the envelope
 * creation and configuration process through a fluent API.
 *
 * Design pattern: Builder - Separates the construction of complex objects
 * from their representation, allowing the same construction process to
 * create different representations.
 */
abstract class NotificationBuilder implements NotificationBuilderInterface
{
    use Macroable;
    use NotificationBuilderMethods;
    use NotificationMethodAliases;
    use NotificationStorageMethods;

    /**
     * Creates a new NotificationBuilder instance.
     *
     * This constructor accepts either a notification object or a string representing
     * the plugin name. In the latter case, it creates a new notification and sets
     * the plugin stamp accordingly.
     *
     * @param string|NotificationInterface $notification   Either a notification object or a plugin name
     * @param StorageManagerInterface      $storageManager The storage manager for persisting notifications
     */
    public function __construct(string|NotificationInterface $notification, StorageManagerInterface $storageManager)
    {
        if (\is_string($notification)) {
            $plugin = new PluginStamp($notification);

            $notification = Envelope::wrap(new Notification());
            $notification->withStamp($plugin);
        }

        $envelope = Envelope::wrap($notification);
        $envelope->withStamp(new PluginStamp('flasher'), false);

        $this->envelope = $envelope;

        $this->storageManager = $storageManager;
    }
}
