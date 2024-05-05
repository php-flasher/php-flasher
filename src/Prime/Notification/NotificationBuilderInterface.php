<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\StampInterface;

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

    public function priority(int $priority): static;

    public function keep(): static;

    public function hops(int $amount): static;

    public function delay(int $delay): static;

    /**
     * @param array<string, mixed> $parameters
     */
    public function translate(array $parameters = [], ?string $locale = null): static;

    public function handler(string $handler): static;

    /**
     * @param array<string, mixed> $context
     */
    public function context(array $context): static;

    public function when(bool|\Closure $condition): static;

    public function unless(bool|\Closure $condition): static;

    /**
     * @param StampInterface[]|StampInterface $stamps
     */
    public function with(array|StampInterface $stamps): static;

    public function getEnvelope(): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $parameters
     */
    public function preset(string $preset, array $parameters = []): Envelope;

    public function operation(string $operation, string|object|null $resource = null): Envelope;

    public function created(string|object|null $resource = null): Envelope;

    public function updated(string|object|null $resource = null): Envelope;

    public function saved(string|object|null $resource = null): Envelope;

    public function deleted(string|object|null $resource = null): Envelope;

    public function push(): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function addSuccess(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function addError(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function addInfo(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function addWarning(string $message, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $options
     */
    public function addFlash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope;

    /**
     * @param array<string, mixed> $parameters
     */
    public function addPreset(string $preset, array $parameters = []): Envelope;

    public function addCreated(string|object|null $resource = null): Envelope;

    public function addUpdated(string|object|null $resource = null): Envelope;

    public function addSaved(string|object|null $resource = null): Envelope;

    public function addDeleted(string|object|null $resource = null): Envelope;

    public function addOperation(string $operation, string|object|null $resource = null): Envelope;
}
