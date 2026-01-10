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
     * Gets the title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Gets the message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets the message.
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Gets the type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets the type.
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets all options.
     *
     * @return array<string, mixed>
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
     * Gets a specific option with a default fallback.
     */
    public function getOption(string $name, mixed $default = null): mixed
    {
        return \array_key_exists($name, $this->options)
            ? $this->options[$name]
            : $default;
    }

    /**
     * Sets a specific option.
     */
    public function setOption(string $name, mixed $value): void
    {
        $this->options[$name] = $value;
    }

    /**
     * Unsets a specific option.
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
