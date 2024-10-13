<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

/**
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
     * @phpstan-param NotificationType $type
     */
    public function type(string $type): static
    {
        return parent::type($type);
    }

    /**
     * @param OptionsType $options
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::success($message, $options, $title);
    }

    /**
     * @param OptionsType $options
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::error($message, $options, $title);
    }

    /**
     * @param OptionsType $options
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::info($message, $options, $title);
    }

    /**
     * @param OptionsType $options
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::warning($message, $options, $title);
    }

    /**
     * @phpstan-param NotificationType $type
     * @phpstan-param OptionsType      $options
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        return parent::flash($type, $message, $options, $title);
    }

    /**
     * @param OptionsType $options
     */
    public function options(array $options, bool $append = true): static
    {
        return parent::options($options, $append);
    }

    /**
     * @template T of OptionsType
     * @template K of key-of<T>
     *
     * @phpstan-param K $name
     * @phpstan-param T[K] $value
     */
    public function option(string $name, mixed $value): static
    {
        return parent::option($name, $value);
    }

    public function timeout(int $milliseconds): self
    {
        $this->option('timeout', $milliseconds);

        return $this;
    }

    /**
     * @param "top"|"bottom" $direction
     */
    public function direction(string $direction): self
    {
        $this->option('direction', $direction);

        return $this;
    }

    /**
     * @phpstan-param OptionsType['position'] $position
     */
    public function position(string $position): self
    {
        $this->option('position', $position);

        return $this;
    }
}
