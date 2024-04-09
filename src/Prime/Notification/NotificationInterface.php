<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

interface NotificationInterface
{
    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function getMessage(): string;

    public function setMessage(string $message): void;

    public function getType(): string;

    public function setType(string $type): void;

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array;

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options): void;

    public function getOption(string $name, mixed $default = null): mixed;

    public function setOption(string $name, mixed $value): void;

    public function unsetOption(string $name): void;

    /**
     * @return array{
     *     title: string,
     *     message: string,
     *     type: string,
     *     options: array<string, mixed>,
     * }
     */
    public function toArray(): array;
}
