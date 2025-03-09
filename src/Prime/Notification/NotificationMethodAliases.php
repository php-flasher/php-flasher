<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

/**
 * Provides alternative method names for notification creation.
 *
 * This trait implements aliases for the standard notification methods, offering
 * alternative naming conventions with 'add' prefix. These aliases improve API
 * usability by providing familiar method names for developers coming from different
 * frameworks.
 */
trait NotificationMethodAliases
{
    /**
     * Alias for success() method.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addSuccess(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->success($message, $options, $title);
    }

    /**
     * Alias for error() method.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addError(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->error($message, $options, $title);
    }

    /**
     * Alias for info() method.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addInfo(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->info($message, $options, $title);
    }

    /**
     * Alias for warning() method.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addWarning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->warning($message, $options, $title);
    }

    /**
     * Alias for flash() method.
     *
     * @param string|null          $type    The notification type
     * @param string|null          $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addFlash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash($type, $message, $options, $title);
    }

    /**
     * Alias for preset() method.
     *
     * @param string               $preset     The preset name
     * @param array<string, mixed> $parameters Template parameters
     *
     * @return Envelope The created notification envelope
     */
    public function addPreset(string $preset, array $parameters = []): Envelope
    {
        return $this->preset($preset, $parameters);
    }

    /**
     * Alias for created() method.
     *
     * @param string|object|null $resource The resource that was created
     *
     * @return Envelope The created notification envelope
     */
    public function addCreated(string|object|null $resource = null): Envelope
    {
        return $this->created($resource);
    }

    /**
     * Alias for updated() method.
     *
     * @param string|object|null $resource The resource that was updated
     *
     * @return Envelope The created notification envelope
     */
    public function addUpdated(string|object|null $resource = null): Envelope
    {
        return $this->updated($resource);
    }

    /**
     * Alias for saved() method.
     *
     * @param string|object|null $resource The resource that was saved
     *
     * @return Envelope The created notification envelope
     */
    public function addSaved(string|object|null $resource = null): Envelope
    {
        return $this->saved($resource);
    }

    /**
     * Alias for deleted() method.
     *
     * @param string|object|null $resource The resource that was deleted
     *
     * @return Envelope The created notification envelope
     */
    public function addDeleted(string|object|null $resource = null): Envelope
    {
        return $this->deleted($resource);
    }

    /**
     * Alias for operation() method.
     *
     * @param string             $operation The operation name
     * @param string|object|null $resource  The resource that was operated on
     *
     * @return Envelope The created notification envelope
     */
    public function addOperation(string $operation, string|object|null $resource = null): Envelope
    {
        return $this->operation($operation, $resource);
    }
}
