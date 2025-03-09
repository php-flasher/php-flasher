<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

/**
 * Default implementation of NotificationInterface.
 *
 * This class represents a notification with its basic properties: title, message,
 * type, and options. It provides the core functionality for storing and
 * manipulating notification data.
 *
 * Design pattern: Value Object - Represents a simple entity with equality based
 * on attribute values rather than identity.
 */
final class Notification implements NotificationInterface
{
    /**
     * The notification title.
     */
    private string $title = '';

    /**
     * The notification message content.
     */
    private string $message = '';

    /**
     * The notification type (e.g., "success", "error", "warning", "info").
     */
    private string $type = '';

    /**
     * Configuration options for the notification.
     *
     * @var array<string, mixed>
     */
    private array $options = [];

    /**
     * Gets the title of the notification.
     *
     * @return string The notification title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title of the notification.
     *
     * @param string $title The title to set
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Gets the message of the notification.
     *
     * @return string The notification message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets the message of the notification.
     *
     * @param string $message The message to set
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Gets the type of the notification.
     *
     * @return string The notification type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets the type of the notification.
     *
     * @param string $type The type to set
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets all options of the notification.
     *
     * @return array<string, mixed> The notification options
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Sets or updates the options of the notification.
     *
     * This method merges the provided options with existing ones,
     * with new values taking precedence over existing values.
     *
     * @param array<string, mixed> $options The options to set or update
     */
    public function setOptions(array $options): void
    {
        $this->options = array_replace($this->options, $options);
    }

    /**
     * Gets a specific option of the notification with a default fallback.
     *
     * @param string $name    The name of the option
     * @param mixed  $default The default value to return if the option is not set
     *
     * @return mixed The option value or the default value
     */
    public function getOption(string $name, mixed $default = null): mixed
    {
        return \array_key_exists($name, $this->options)
            ? $this->options[$name]
            : $default;
    }

    /**
     * Sets a specific option for the notification.
     *
     * @param string $name  The name of the option
     * @param mixed  $value The value of the option
     */
    public function setOption(string $name, mixed $value): void
    {
        $this->options[$name] = $value;
    }

    /**
     * Unsets a specific option of the notification.
     *
     * @param string $name The name of the option to unset
     */
    public function unsetOption(string $name): void
    {
        unset($this->options[$name]);
    }

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
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'options' => $this->options,
        ];
    }
}
