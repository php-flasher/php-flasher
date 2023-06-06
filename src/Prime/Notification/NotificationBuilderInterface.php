<?php

namespace Flasher\Prime\Notification;

use Flasher\Prime\Translation\ResourceInterface;

interface NotificationBuilderInterface
{
    public function title(string $title): static;

    public function message(string $message): static;

    public function type(string $type): static;

    /**
     * @param array<string, mixed> $options
     */
    public function options(array $options, bool $merge = true): static;

    public function option(string $name, mixed $value): static;

    /**
     * @param array<string, mixed> $options
     */
    public function success(string $message, array $options = [], string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function error(string $message, array $options = [], string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function info(string $message, array $options = [], string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function warning(string $message, array $options = [], string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function flash(string $type = null, string $message = null, array $options = [], string $title = null): Envelope;

    /**
     * @param array<string, mixed> $parameters
     */
    public function preset(string $preset, array $parameters = []): Envelope;

    public function operation(string $operation, string|ResourceInterface $resource = null): Envelope;

    public function created(string|ResourceInterface $resource = null): Envelope;

    public function updated(string|ResourceInterface $resource = null): Envelope;

    public function saved(string|ResourceInterface $resource = null): Envelope;

    public function deleted(string|ResourceInterface $resource = null): Envelope;

    public function push(): Envelope;
}
