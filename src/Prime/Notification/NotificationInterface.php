<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

/**
 * NotificationInterface - The core notification contract.
 *
 * Defines the essential properties and behaviors of a notification.
 * All notification implementations must adhere to this interface.
 *
 * Design pattern: Component Interface - Establishes a common contract
 * for notification objects throughout the system.
 */
interface NotificationInterface
{
    /**
     * Gets the title of the notification.
     *
     * @return string The notification title
     */
    public function getTitle(): string;

    /**
     * Sets the title of the notification.
     *
     * @param string $title The title to set
     */
    public function setTitle(string $title): void;

    /**
     * Gets the message content of the notification.
     *
     * @return string The notification message
     */
    public function getMessage(): string;

    /**
     * Sets the message content of the notification.
     *
     * @param string $message The message to set
     */
    public function setMessage(string $message): void;

    /**
     * Gets the type of the notification.
     *
     * Common types include "success", "error", "info", and "warning".
     *
     * @return string The notification type
     */
    public function getType(): string;

    /**
     * Sets the type of the notification.
     *
     * @param string $type The type to set
     */
    public function setType(string $type): void;

    /**
     * Gets all options of the notification.
     *
     * @return array<string, mixed> The notification options
     */
    public function getOptions(): array;

    /**
     * Sets or updates the options of the notification.
     *
     * @param array<string, mixed> $options The options to set or update
     */
    public function setOptions(array $options): void;

    /**
     * Gets a specific option of the notification with a default fallback.
     *
     * @param string $name    The name of the option
     * @param mixed  $default The default value to return if the option is not set
     *
     * @return mixed The option value or the default value
     */
    public function getOption(string $name, mixed $default = null): mixed;

    /**
     * Sets a specific option for the notification.
     *
     * @param string $name  The name of the option
     * @param mixed  $value The value of the option
     */
    public function setOption(string $name, mixed $value): void;

    /**
     * Unsets a specific option of the notification.
     *
     * @param string $name The name of the option to unset
     */
    public function unsetOption(string $name): void;

    /**
     * Converts the notification into an associative array.
     *
     * @return array{
     *     title: string,
     *     message: string,
     *     type: string,
     *     options: array<string, mixed>,
     * } The notification as an array
     */
    public function toArray(): array;
}
