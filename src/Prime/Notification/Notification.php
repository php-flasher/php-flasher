<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

final class Notification implements NotificationInterface
{
    private string $title = '';

    private string $message = '';

    private string $type = '';

    /**
     * @var array<string, mixed> options for the notification
     */
    private array $options = [];

    /**
     * Gets the title of the notification.
     *
     * @return string the notification title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title of the notification.
     *
     * @param string $title the title to set
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Gets the message of the notification.
     *
     * @return string the notification message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets the message of the notification.
     *
     * @param string $message the message to set
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Gets the type of the notification.
     *
     * @return string the notification type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets the type of the notification.
     *
     * @param string $type the type to set
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets all options of the notification.
     *
     * @return array<string, mixed> the notification options
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Sets or updates the options of the notification.
     *
     * @param array<string, mixed> $options the options to set or update
     */
    public function setOptions(array $options): void
    {
        $this->options = array_replace($this->options, $options);
    }

    /**
     * Gets a specific option of the notification with a default fallback.
     *
     * @param string $name    the name of the option
     * @param mixed  $default the default value to return if the option is not set
     *
     * @return mixed the option value or the default value
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
     * @param string $name  the name of the option
     * @param mixed  $value the value of the option
     */
    public function setOption(string $name, mixed $value): void
    {
        $this->options[$name] = $value;
    }

    /**
     * Unsets a specific option of the notification.
     *
     * @param string $name the name of the option to unset
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
     * }
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
