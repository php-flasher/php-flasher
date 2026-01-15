<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilder;

/**
 * @phpstan-type NotificationType "success"|"info"|"warning"|"error"|"alert"|"information"
 * @phpstan-type OptionsType array{
 *     layout?: "top"|"topLeft"|"topCenter"|"topRight"|"center"|"centerLeft"|"centerRight"|"bottom"|"bottomLeft"|"bottomCenter"|"bottomRight",
 *     theme?: "relax"|"mint"|"metroui",
 *     timeout?: false|int,
 *     progressBar?: bool,
 *     closeWith?: string[],
 *     animation?: array{
 *         open?: string|null,
 *         close?: string|null,
 *     },
 *     sounds?: array{
 *         sources?: string[],
 *         volume?: int,
 *         conditions?: string[],
 *     },
 *     docTitle?: array{
 *         conditions?: string[],
 *     },
 *     modal?: bool,
 *     id?: bool|string,
 *     force?: bool,
 *     queue?: string,
 *     killer?: bool|string,
 *     container?: false|string,
 *     buttons?: string[],
 *     visibilityControl?: bool,
 * }
 */
final class NotyBuilder extends NotificationBuilder
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
     * @phpstan-param NotificationType|null $type
     * @phpstan-param OptionsType           $options
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

    public function text(string $text): self
    {
        return $this->message($text);
    }

    /**
     * @param OptionsType $options
     */
    public function alert(?string $message = null, ?string $title = null, array $options = []): self
    {
        $this->type('alert');

        if ($message) {
            $this->message($message);
        }

        if ($title) {
            $this->title($title);
        }

        if ([] !== $options) {
            $this->options($options);
        }

        return $this;
    }

    /**
     * @phpstan-param OptionsType['layout'] $layout
     */
    public function layout(string $layout): self
    {
        $this->option('layout', $layout);

        return $this;
    }

    /**
     * @phpstan-param OptionsType['theme'] $theme
     */
    public function theme(string $theme): self
    {
        $this->option('theme', $theme);

        return $this;
    }

    public function timeout(false|int $timeout): self
    {
        $this->option('timeout', $timeout);

        return $this;
    }

    public function progressBar(bool $progressBar = false): self
    {
        $this->option('progressBar', $progressBar);

        return $this;
    }

    /**
     * @param string[] $closeWith
     */
    public function closeWith(string|array $closeWith): self
    {
        $this->option('closeWith', (array) $closeWith);

        return $this;
    }

    /**
     * @param 'open'|'close' $option
     * @param 'noty_effects_open'|'noty_effects_close'|string $effect
     */
    public function animation(string $option, string $effect): self
    {
        /** @phpstan-var OptionsType['animation'] $animation */
        $animation = $this->getEnvelope()->getOption('animation', []);
        $animation[$option] = $effect;

        $this->option('animation', $animation);

        return $this;
    }

    /**
     * @phpstan-param "sources"|"volume"|"conditions" $option
     * @phpstan-param ($option is "sources" ? string[] :
     *        ($option is "volume" ? int :
     *        ($option is "conditions" ? string[] :
     *        mixed))) $value
     */
    public function sounds(string $option, mixed $value): self
    {
        /** @phpstan-var OptionsType['sounds'] $sounds */
        $sounds = $this->getEnvelope()->getOption('sounds', []);
        $sounds[$option] = $value;

        $this->option('sounds', $sounds); // @phpstan-ignore-line

        return $this;
    }

    /**
     * @phpstan-param "conditions"|string $option
     * @phpstan-param ($option is "conditions" ? string[] : mixed) $value
     */
    public function docTitle(string $option, mixed $value): self
    {
        /** @phpstan-var OptionsType['docTitle'] $docTitle */
        $docTitle = $this->getEnvelope()->getOption('docTitle', []);
        $docTitle[$option] = $value;

        $this->option('docTitle', $docTitle); // @phpstan-ignore-line

        return $this;
    }

    public function modal(bool $modal = true): self
    {
        $this->option('modal', $modal);

        return $this;
    }

    public function id(bool|string $id): self
    {
        $this->option('id', $id);

        return $this;
    }

    public function force(bool $force = true): self
    {
        $this->option('force', $force);

        return $this;
    }

    public function queue(string $queue): self
    {
        $this->option('queue', $queue);

        return $this;
    }

    public function killer(bool|string $killer): self
    {
        $this->option('killer', $killer);

        return $this;
    }

    public function container(false|string $container): self
    {
        $this->option('container', $container);

        return $this;
    }

    /**
     * @param string[] $buttons
     */
    public function buttons(array $buttons): self
    {
        $this->option('buttons', $buttons);

        return $this;
    }

    public function visibilityControl(bool $visibilityControl): self
    {
        $this->option('visibilityControl', $visibilityControl);

        return $this;
    }
}
