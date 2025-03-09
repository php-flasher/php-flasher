<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Storage\StorageManagerInterface;

/**
 * Implements notification creation and storage methods.
 *
 * This trait provides the concrete implementations for creating different types
 * of notifications and storing them via the storage manager. It implements the
 * final step in the builder pattern by creating and persisting notifications.
 */
trait NotificationStorageMethods
{
    /**
     * The storage manager for persisting notifications.
     */
    protected readonly StorageManagerInterface $storageManager;

    /**
     * Creates and stores a success notification.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash(Type::SUCCESS, $message, $options, $title);
    }

    /**
     * Creates and stores an error notification.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash(Type::ERROR, $message, $options, $title);
    }

    /**
     * Creates and stores an info notification.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash(Type::INFO, $message, $options, $title);
    }

    /**
     * Creates and stores a warning notification.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash(Type::WARNING, $message, $options, $title);
    }

    /**
     * Creates and stores a notification with specified type.
     *
     * This is the core method used by specific notification type methods.
     * It configures the notification based on the provided parameters and
     * then stores it via push().
     *
     * @param string|null          $type    The notification type
     * @param string|null          $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        if (null !== $type) {
            $this->type($type);
        }

        if (null !== $message) {
            $this->message($message);
        }

        if ([] !== $options) {
            $this->options($options);
        }

        if (null !== $title) {
            $this->title($title);
        }

        return $this->push();
    }

    /**
     * Creates a notification from a named preset template.
     *
     * Presets allow defining common notification templates in configuration,
     * which can be reused with different parameters.
     *
     * @param string               $preset     The preset name
     * @param array<string, mixed> $parameters Template parameters
     *
     * @return Envelope The created notification envelope
     */
    public function preset(string $preset, array $parameters = []): Envelope
    {
        $this->envelope->withStamp(new PresetStamp($preset, $parameters));

        return $this->push();
    }

    /**
     * Creates a notification for a generic operation on a resource.
     *
     * @param string             $operation The operation name (e.g., "created", "updated")
     * @param string|object|null $resource  The resource that was operated on
     *
     * @return Envelope The created notification envelope
     */
    public function operation(string $operation, string|object|null $resource = null): Envelope
    {
        $resource = match (true) {
            \is_string($resource) => $resource,
            \is_object($resource) => $this->resolveResourceName($resource),
            default => null,
        };

        return $this->preset($operation, [':resource' => $resource ?: 'resource']);
    }

    /**
     * Creates a notification for a resource creation operation.
     *
     * @param string|object|null $resource The resource that was created
     *
     * @return Envelope The created notification envelope
     */
    public function created(string|object|null $resource = null): Envelope
    {
        return $this->operation('created', $resource);
    }

    /**
     * Creates a notification for a resource update operation.
     *
     * @param string|object|null $resource The resource that was updated
     *
     * @return Envelope The created notification envelope
     */
    public function updated(string|object|null $resource = null): Envelope
    {
        return $this->operation('updated', $resource);
    }

    /**
     * Creates a notification for a resource save operation.
     *
     * @param string|object|null $resource The resource that was saved
     *
     * @return Envelope The created notification envelope
     */
    public function saved(string|object|null $resource = null): Envelope
    {
        return $this->operation('saved', $resource);
    }

    /**
     * Creates a notification for a resource deletion operation.
     *
     * @param string|object|null $resource The resource that was deleted
     *
     * @return Envelope The created notification envelope
     */
    public function deleted(string|object|null $resource = null): Envelope
    {
        return $this->operation('deleted', $resource);
    }

    /**
     * Finalizes and stores the current notification.
     *
     * This method completes the builder process, stores the notification
     * in the storage manager, and returns the final envelope.
     *
     * @return Envelope The stored notification envelope
     */
    public function push(): Envelope
    {
        $envelope = $this->getEnvelope();

        $this->storageManager->add($envelope);

        return $envelope;
    }

    /**
     * Resolves a display name for a resource object.
     *
     * This method tries to determine a user-friendly name for an object by:
     * 1. Checking if the object has a getFlashIdentifier() method
     * 2. Falling back to the simple class name if not
     *
     * @param object $object The object to resolve a name for
     *
     * @return string|null The resolved name
     */
    private function resolveResourceName(object $object): ?string
    {
        $displayName = \is_callable([$object, 'getFlashIdentifier']) ? $object->getFlashIdentifier() : null;

        return $displayName ?: basename(str_replace('\\', '/', $object::class));
    }
}
