<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

/**
 * FlasherBuilder - Default implementation of the notification builder.
 *
 * Provides methods for building and configuring flasher-specific notifications.
 * Extends the core builder with additional type-safety and convenience methods.
 *
 * Design pattern: Concrete Builder - Implements the builder interface
 * with specific behaviors for flasher notifications.
 *
 * @phpstan-type NotificationType "success"|"info"|"warning"|"error"
 * @phpstan-type OptionsType array{
 *     timeout?: int,
 *     timeouts?: array<string, int>,
 *     fps?: int,
 *     position?: "top-right"|"top-left"|"top-center"|"bottom-right"|"bottom-left"|"bottom-center",
 *     direction?: "top"|"bottom",
 *     rtl?: bool,
 *     style?: array<string, mixed>,
 *     escapeHtml?: bool,
 * }
 */
final class FlasherBuilder extends NotificationBuilder
{
    /**
     * Sets the notification type with type-safety.
     *
     * @phpstan-param NotificationType $type The notification type (success, info, warning, error)
     *
     * @return static The builder instance for method chaining
     */
    public function type(string $type): static
    {
        return parent::type($type);
    }

    /**
     * Creates and stores a success notification.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Optional configuration for the notification
     * @param string|null $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::success($message, $options, $title);
    }

    /**
     * Creates and stores an error notification.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Optional configuration for the notification
     * @param string|null $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::error($message, $options, $title);
    }

    /**
     * Creates and stores an info notification.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Optional configuration for the notification
     * @param string|null $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::info($message, $options, $title);
    }

    /**
     * Creates and stores a warning notification.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Optional configuration for the notification
     * @param string|null $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::warning($message, $options, $title);
    }

    /**
     * Creates and stores a notification with specified type.
     *
     * This is a general-purpose method that can be used to create notifications
     * of any type, with complete control over all parameters.
     *
     * @phpstan-param NotificationType|null $type    The notification type
     * @phpstan-param OptionsType           $options Optional configuration for the notification
     *
     * @param string|null $message The notification message
     * @param string|null $title   Optional title for the notification
     *
     * @return Envelope The created and stored notification envelope
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        return parent::flash($type, $message, $options, $title);
    }

    /**
     * Sets multiple options for the notification.
     *
     * @param OptionsType $options Configuration options for the notification
     * @param bool        $append  Whether to merge with existing options (true) or replace them (false)
     *
     * @return static The builder instance for method chaining
     */
    public function options(array $options, bool $append = true): static
    {
        return parent::options($options, $append);
    }

    /**
     * Sets a single option for the notification.
     *
     * @template T of OptionsType
     * @template K of key-of<T>
     *
     * @phpstan-param K      $name  The option name
     * @phpstan-param T[K]   $value The option value
     *
     * @return static The builder instance for method chaining
     */
    public function option(string $name, mixed $value): static
    {
        return parent::option($name, $value);
    }

    /**
     * Sets the display timeout for the notification.
     *
     * @param int $milliseconds The timeout duration in milliseconds (0 for no timeout)
     *
     * @return self The builder instance for method chaining
     */
    public function timeout(int $milliseconds): self
    {
        $this->option('timeout', $milliseconds);

        return $this;
    }

    /**
     * Sets the stacking direction for notifications.
     *
     * @param "top"|"bottom" $direction The direction in which notifications should stack
     *                                  - 'top': newer notifications appear above older ones
     *                                  - 'bottom': newer notifications appear below older ones
     *
     * @return self The builder instance for method chaining
     */
    public function direction(string $direction): self
    {
        $this->option('direction', $direction);

        return $this;
    }

    /**
     * Sets the display position for notifications.
     *
     * @phpstan-param OptionsType['position'] $position The position on screen
     *                                                 (top-right, top-left, top-center,
     *                                                  bottom-right, bottom-left, bottom-center)
     *
     * @return self The builder instance for method chaining
     */
    public function position(string $position): self
    {
        $this->option('position', $position);

        return $this;
    }
}
