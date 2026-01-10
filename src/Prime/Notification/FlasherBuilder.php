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
     * Sets the notification type.
     *
     * @phpstan-param NotificationType $type
     */
    public function type(string $type): static
    {
        return parent::type($type);
    }

    /**
     * Creates and stores a success notification.
     *
     * @param OptionsType $options
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::success($message, $options, $title);
    }

    /**
     * Creates and stores an error notification.
     *
     * @param OptionsType $options
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::error($message, $options, $title);
    }

    /**
     * Creates and stores an info notification.
     *
     * @param OptionsType $options
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::info($message, $options, $title);
    }

    /**
     * Creates and stores a warning notification.
     *
     * @param OptionsType $options
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::warning($message, $options, $title);
    }

    /**
     * Creates and stores a notification with specified type.
     *
     * @phpstan-param NotificationType|null $type
     * @phpstan-param OptionsType           $options
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        return parent::flash($type, $message, $options, $title);
    }

    /**
     * Sets multiple options.
     *
     * @param OptionsType $options
     */
    public function options(array $options, bool $append = true): static
    {
        return parent::options($options, $append);
    }

    /**
     * Sets a single option.
     *
     * @template T of OptionsType
     * @template K of key-of<T>
     *
     * @phpstan-param K    $name
     * @phpstan-param T[K] $value
     */
    public function option(string $name, mixed $value): static
    {
        return parent::option($name, $value);
    }

    /**
     * Sets the display timeout.
     */
    public function timeout(int $milliseconds): self
    {
        $this->option('timeout', $milliseconds);

        return $this;
    }

    /**
     * Sets the stacking direction.
     *
     * @param "top"|"bottom" $direction
     */
    public function direction(string $direction): self
    {
        $this->option('direction', $direction);

        return $this;
    }

    /**
     * Sets the display position.
     *
     * @phpstan-param OptionsType['position'] $position
     */
    public function position(string $position): self
    {
        $this->option('position', $position);

        return $this;
    }
}
