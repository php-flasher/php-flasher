<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

final class Notification implements NotificationInterface
{
    private string $title = '';

    private string $message = '';

    private string $type = '';

    /**
     * @var array<string, mixed>
     */
    private array $options = [];

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = array_replace($this->options, $options);
    }

    public function getOption(string $name, mixed $default = null): mixed
    {
        return array_key_exists($name, $this->options)
            ? $this->options[$name]
            : $default;
    }

    public function setOption(string $name, mixed $value): void
    {
        $this->options[$name] = $value;
    }

    public function unsetOption(string $name): void
    {
        unset($this->options[$name]);
    }

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
