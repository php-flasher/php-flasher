<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\StampInterface;

/**
 * NotificationBuilderInterface - Fluent interface for notification creation.
 *
 * Provides a rich, fluent API for constructing notifications with various
 * options and behaviors. Simplifies the process of creating and configuring
 * notifications.
 *
 * Design pattern: Builder - Separates the construction of complex objects
 * from their representation, allowing the same construction process to
 * create different representations.
 */
interface NotificationBuilderInterface
{
    /**
     * Sets the notification title.
     *
     * @param string $title The title to set
     *
     * @return static The builder instance for method chaining
     */
    public function title(string $title): static;

    /**
     * Sets the notification message.
     *
     * @param string $message The message to set
     *
     * @return static The builder instance for method chaining
     */
    public function message(string $message): static;

    /**
     * Sets the notification type.
     *
     * @param string $type The type to set (e.g., "success", "error", "info", "warning")
     *
     * @return static The builder instance for method chaining
     */
    public function type(string $type): static;

    /**
     * Sets multiple options for the notification.
     *
     * @param array<string, mixed> $options The options to set
     * @param bool                 $merge   Whether to merge with existing options (true) or replace them (false)
     *
     * @return static The builder instance for method chaining
     */
    public function options(array $options, bool $merge = true): static;

    /**
     * Sets a single option for the notification.
     *
     * @param string $name  The option name
     * @param mixed  $value The option value
     *
     * @return static The builder instance for method chaining
     */
    public function option(string $name, mixed $value): static;

    /**
     * Sets the notification priority.
     *
     * Higher priority notifications are typically displayed before lower priority ones.
     *
     * @param int $priority The priority value (higher values indicate higher priority)
     *
     * @return static The builder instance for method chaining
     */
    public function priority(int $priority): static;

    /**
     * Increases the number of request hops the notification will persist.
     *
     * This method is useful for keeping a notification across multiple redirects.
     *
     * @return static The builder instance for method chaining
     */
    public function keep(): static;

    /**
     * Sets the exact number of request hops the notification will persist.
     *
     * @param int $amount The number of hops to keep the notification
     *
     * @return static The builder instance for method chaining
     */
    public function hops(int $amount): static;

    /**
     * Sets a delay before showing the notification.
     *
     * @param int $delay The delay in milliseconds
     *
     * @return static The builder instance for method chaining
     */
    public function delay(int $delay): static;

    /**
     * Configures translation parameters for the notification.
     *
     * @param array<string, mixed> $parameters Translation parameters
     * @param string|null          $locale     Specific locale to use, or null for default
     *
     * @return static The builder instance for method chaining
     */
    public function translate(array $parameters = [], ?string $locale = null): static;

    /**
     * Sets the handler (plugin) that should process the notification.
     *
     * @param string $handler The handler/plugin name (e.g., "toastr", "sweetalert")
     *
     * @return static The builder instance for method chaining
     */
    public function handler(string $handler): static;

    /**
     * Sets additional context data for the notification.
     *
     * @param array<string, mixed> $context The context data
     *
     * @return static The builder instance for method chaining
     */
    public function context(array $context): static;

    /**
     * Adds a condition that must be true for the notification to be displayed.
     *
     * @param bool|\Closure $condition A boolean or closure returning a boolean
     *
     * @return static The builder instance for method chaining
     */
    public function when(bool|\Closure $condition): static;

    /**
     * Adds a condition that must be false for the notification to be displayed.
     *
     * @param bool|\Closure $condition A boolean or closure returning a boolean
     *
     * @return static The builder instance for method chaining
     */
    public function unless(bool|\Closure $condition): static;

    /**
     * Adds one or more stamps to the notification envelope.
     *
     * @param StampInterface[]|StampInterface $stamps The stamps to add
     *
     * @return static The builder instance for method chaining
     */
    public function with(array|StampInterface $stamps): static;

    /**
     * Gets the current notification envelope.
     *
     * @return Envelope The notification envelope
     */
    public function getEnvelope(): Envelope;

    /**
     * Creates and stores a success notification.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * Creates and stores an error notification.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * Creates and stores an info notification.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * Creates and stores a warning notification.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * Creates and stores a notification with specified type.
     *
     * @param string|null          $type    The notification type
     * @param string|null          $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope;

    /**
     * Creates a notification from a named preset template.
     *
     * @param string               $preset     The preset name
     * @param array<string, mixed> $parameters Template parameters
     *
     * @return Envelope The created notification envelope
     */
    public function preset(string $preset, array $parameters = []): Envelope;

    /**
     * Creates a notification for a generic operation on a resource.
     *
     * @param string             $operation The operation name (e.g., "created", "updated")
     * @param string|object|null $resource  The resource that was operated on
     *
     * @return Envelope The created notification envelope
     */
    public function operation(string $operation, string|object|null $resource = null): Envelope;

    /**
     * Creates a notification for a resource creation operation.
     *
     * @param string|object|null $resource The resource that was created
     *
     * @return Envelope The created notification envelope
     */
    public function created(string|object|null $resource = null): Envelope;

    /**
     * Creates a notification for a resource update operation.
     *
     * @param string|object|null $resource The resource that was updated
     *
     * @return Envelope The created notification envelope
     */
    public function updated(string|object|null $resource = null): Envelope;

    /**
     * Creates a notification for a resource save operation.
     *
     * @param string|object|null $resource The resource that was saved
     *
     * @return Envelope The created notification envelope
     */
    public function saved(string|object|null $resource = null): Envelope;

    /**
     * Creates a notification for a resource deletion operation.
     *
     * @param string|object|null $resource The resource that was deleted
     *
     * @return Envelope The created notification envelope
     */
    public function deleted(string|object|null $resource = null): Envelope;

    /**
     * Finalizes and stores the current notification.
     *
     * @return Envelope The stored notification envelope
     */
    public function push(): Envelope;

    /**
     * Alias for success() method.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addSuccess(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * Alias for error() method.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addError(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * Alias for info() method.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addInfo(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * Alias for warning() method.
     *
     * @param string               $message The notification message
     * @param array<string, mixed> $options Optional configuration for the notification
     * @param string|null          $title   Optional title for the notification
     *
     * @return Envelope The created notification envelope
     */
    public function addWarning(string $message, array $options = [], ?string $title = null): Envelope;

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
    public function addFlash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope;

    /**
     * Alias for preset() method.
     *
     * @param string               $preset     The preset name
     * @param array<string, mixed> $parameters Template parameters
     *
     * @return Envelope The created notification envelope
     */
    public function addPreset(string $preset, array $parameters = []): Envelope;

    /**
     * Alias for created() method.
     *
     * @param string|object|null $resource The resource that was created
     *
     * @return Envelope The created notification envelope
     */
    public function addCreated(string|object|null $resource = null): Envelope;

    /**
     * Alias for updated() method.
     *
     * @param string|object|null $resource The resource that was updated
     *
     * @return Envelope The created notification envelope
     */
    public function addUpdated(string|object|null $resource = null): Envelope;

    /**
     * Alias for saved() method.
     *
     * @param string|object|null $resource The resource that was saved
     *
     * @return Envelope The created notification envelope
     */
    public function addSaved(string|object|null $resource = null): Envelope;

    /**
     * Alias for deleted() method.
     *
     * @param string|object|null $resource The resource that was deleted
     *
     * @return Envelope The created notification envelope
     */
    public function addDeleted(string|object|null $resource = null): Envelope;

    /**
     * Alias for operation() method.
     *
     * @param string             $operation The operation name
     * @param string|object|null $resource  The resource that was operated on
     *
     * @return Envelope The created notification envelope
     */
    public function addOperation(string $operation, string|object|null $resource = null): Envelope;
}
