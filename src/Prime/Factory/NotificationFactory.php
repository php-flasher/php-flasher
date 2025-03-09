<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\ForwardsCalls;

/**
 * Base abstract class for notification factories.
 *
 * This abstract class provides common functionality for all notification factories,
 * such as storage management and method forwarding to notification builders.
 * Specific factory implementations should extend this class and implement
 * the createNotificationBuilder() method.
 *
 * Design pattern: Template Method - Defines the skeleton of an algorithm,
 * deferring some steps to subclasses.
 *
 * @mixin \Flasher\Prime\Notification\NotificationBuilderInterface
 */
abstract class NotificationFactory implements NotificationFactoryInterface
{
    use ForwardsCalls;

    /**
     * Creates a new NotificationFactory instance.
     *
     * @param StorageManagerInterface $storageManager The storage manager for persisting notifications
     * @param string|null             $plugin         The plugin/adapter name (e.g., 'toastr', 'sweetalert')
     */
    public function __construct(
        protected StorageManagerInterface $storageManager,
        protected ?string $plugin = null,
    ) {
    }

    /**
     * Dynamically forwards method calls to a notification builder instance.
     *
     * This magic method allows calling notification builder methods directly on the factory,
     * creating a more fluent API for client code.
     *
     * Example:
     * ```php
     * // Instead of:
     * $factory->createNotificationBuilder()->success('Message');
     *
     * // You can do:
     * $factory->success('Message');
     * ```
     *
     * @param string  $method     The method name to call
     * @param mixed[] $parameters The parameters to pass to the method
     *
     * @return mixed The result of the method call
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->forwardCallTo($this->createNotificationBuilder(), $method, $parameters);
    }
}
