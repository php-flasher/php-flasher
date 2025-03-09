<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\NotificationBuilder;

/**
 * NotyBuilder - Builder implementation for Noty.js notifications.
 *
 * This class provides a fluent interface for configuring Noty.js notifications.
 * It extends the core notification builder with Noty-specific options and
 * features, such as layout, theme, animation, and more.
 *
 * Design patterns:
 * - Builder: Provides a fluent interface for constructing complex objects
 * - Fluent Interface: Methods return $this for method chaining
 * - Type Safety: Uses PHPStan annotations for compile-time type checking
 *
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
     * Sets the notification type with Noty-specific type checking.
     *
     * @phpstan-param NotificationType $type The notification type
     *
     * @return static The builder instance
     */
    public function type(string $type): static
    {
        return parent::type($type);
    }

    /**
     * Creates a success notification with Noty-specific options.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Noty-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function success(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::success($message, $options, $title);
    }

    /**
     * Creates an error notification with Noty-specific options.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Noty-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function error(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::error($message, $options, $title);
    }

    /**
     * Creates an info notification with Noty-specific options.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Noty-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function info(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::info($message, $options, $title);
    }

    /**
     * Creates a warning notification with Noty-specific options.
     *
     * @param string      $message The notification message
     * @param OptionsType $options Noty-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function warning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return parent::warning($message, $options, $title);
    }

    /**
     * Creates a notification of the specified type with Noty-specific options.
     *
     * @phpstan-param NotificationType|null $type    The notification type
     * @phpstan-param OptionsType           $options Noty-specific options
     *
     * @param string|null $type    The notification type
     * @param string|null $message The notification message
     * @param array       $options Noty-specific options
     * @param string|null $title   The notification title
     *
     * @return Envelope The notification envelope
     */
    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        return parent::flash($type, $message, $options, $title);
    }

    /**
     * Sets notification options with Noty-specific type checking.
     *
     * @param OptionsType $options The notification options
     * @param bool        $append  Whether to append or replace existing options
     *
     * @return static The builder instance
     */
    public function options(array $options, bool $append = true): static
    {
        return parent::options($options, $append);
    }

    /**
     * Sets a specific notification option with Noty-specific type checking.
     *
     * @template T of OptionsType
     * @template K of key-of<T>
     *
     * @phpstan-param K $name
     * @phpstan-param T[K] $value
     *
     * @param string $name  The option name
     * @param mixed  $value The option value
     *
     * @return static The builder instance
     */
    public function option(string $name, mixed $value): static
    {
        return parent::option($name, $value);
    }

    /**
     * Sets the notification text (alias for message).
     *
     * This string can contain HTML too. But be careful and don't pass user inputs to this parameter.
     *
     * @param string $text The notification text
     *
     * @return self The builder instance
     */
    public function text(string $text): self
    {
        return $this->message($text);
    }

    /**
     * Creates an alert notification.
     *
     * @param string|null $message The notification message
     * @param string|null $title   The notification title
     * @param OptionsType $options Noty-specific options
     *
     * @return self The builder instance
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
     * Sets the notification layout.
     *
     * @phpstan-param OptionsType['layout'] $layout The layout position
     *
     * - ClassName generator uses this value → noty_layout__${layout}
     *
     * @param string $layout The layout position
     *
     * @return self The builder instance
     */
    public function layout(string $layout): self
    {
        $this->option('layout', $layout);

        return $this;
    }

    /**
     * Sets the notification theme.
     *
     * @phpstan-param OptionsType['theme'] $theme The theme name
     *
     * ClassName generator uses this value → noty_theme__${theme}
     *
     * @param string $theme The theme name
     *
     * @return self The builder instance
     */
    public function theme(string $theme): self
    {
        $this->option('theme', $theme);

        return $this;
    }

    /**
     * Sets the notification timeout.
     *
     * false, 1000, 3000, 3500, etc. Delay for closing event in milliseconds (ms).
     * Set 'false' for sticky notifications.
     *
     * @param false|int $timeout The timeout in milliseconds or false for sticky
     *
     * @return self The builder instance
     */
    public function timeout(false|int $timeout): self
    {
        $this->option('timeout', $timeout);

        return $this;
    }

    /**
     * Sets whether to display a progress bar.
     *
     * true, false - Displays a progress bar if timeout is not false.
     *
     * @param bool $progressBar Whether to display a progress bar
     *
     * @return self The builder instance
     */
    public function progressBar(bool $progressBar = false): self
    {
        $this->option('progressBar', $progressBar);

        return $this;
    }

    /**
     * Sets how the notification can be closed.
     *
     * click, button.
     *
     * @param string|string[] $closeWith Close methods
     *
     * @return self The builder instance
     */
    public function closeWith(string|array $closeWith): self
    {
        $this->option('closeWith', (array) $closeWith);

        return $this;
    }

    /**
     * Sets animation effects for opening or closing.
     *
     * @param "open"|"close"                                  $option Which animation to set
     * @param "noty_effects_open"|"noty_effects_close"|string $effect The animation effect
     *
     * If string, assumed to be CSS class name. If null, no animation at all.
     * If function, runs the function. (v3.0.1+)
     * You can use animate.css class names or your custom css animations as well.
     *
     * @return self The builder instance
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
     * Sets sound options for the notification.
     *
     * @phpstan-param "sources"|"volume"|"conditions" $option The sound option to set
     * @phpstan-param ($option is "sources" ? string[] :
     *        ($option is "volume" ? int :
     *        ($option is "conditions" ? string[] :
     *        mixed))) $value The option value
     *
     * @param string $option The sound option to set
     * @param mixed  $value  The option value
     *
     * @return self The builder instance
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
     * Sets document title options for the notification.
     *
     * @phpstan-param "conditions"|string $option The document title option
     * @phpstan-param ($option is "conditions" ? string[] : mixed) $value The option value
     *
     * @param string $option The document title option
     * @param mixed  $value  The option value
     *
     * @return self The builder instance
     */
    public function docTitle(string $option, mixed $value): self
    {
        /** @phpstan-var OptionsType['docTitle'] $docTitle */
        $docTitle = $this->getEnvelope()->getOption('docTitle', []);
        $docTitle[$option] = $value;

        $this->option('docTitle', $docTitle); // @phpstan-ignore-line

        return $this;
    }

    /**
     * Sets whether the notification is modal.
     *
     * @param bool $modal Whether the notification is modal
     *
     * @return self The builder instance
     */
    public function modal(bool $modal = true): self
    {
        $this->option('modal', $modal);

        return $this;
    }

    /**
     * Sets the notification ID.
     *
     * You can use this id with querySelectors. Generated automatically if false.
     *
     * @param bool|string $id The notification ID or false to generate automatically
     *
     * @return self The builder instance
     */
    public function id(bool|string $id): self
    {
        $this->option('id', $id);

        return $this;
    }

    /**
     * Sets whether to force the notification.
     *
     * DOM insert method depends on this parameter. If false uses append, if true uses prepend.
     *
     * @param bool $force Whether to force the notification
     *
     * @return self The builder instance
     */
    public function force(bool $force = true): self
    {
        $this->option('force', $force);

        return $this;
    }

    /**
     * Sets the notification queue.
     *
     * @param string $queue The queue name
     *
     * @return self The builder instance
     */
    public function queue(string $queue): self
    {
        $this->option('queue', $queue);

        return $this;
    }

    /**
     * Sets whether the notification kills other notifications.
     *
     * If true closes all visible notifications and shows itself.
     * If string(queueName) closes all visible notification on this queue and shows itself.
     *
     * @param bool|string $killer Whether to kill other notifications
     *
     * @return self The builder instance
     */
    public function killer(bool|string $killer): self
    {
        $this->option('killer', $killer);

        return $this;
    }

    /**
     * Sets the notification container.
     *
     * Custom container selector string. Like '.my-custom-container'.
     * Layout parameter will be ignored.
     *
     * @param false|string $container The container selector or false to use default
     *
     * @return self The builder instance
     */
    public function container(false|string $container): self
    {
        $this->option('container', $container);

        return $this;
    }

    /**
     * Sets the notification buttons.
     *
     * An array of Noty.button, for creating confirmation dialogs.
     *
     * @param string[] $buttons The buttons configuration
     *
     * @return self The builder instance
     */
    public function buttons(array $buttons): self
    {
        $this->option('buttons', $buttons);

        return $this;
    }

    /**
     * Sets whether to use visibility control.
     *
     * If true Noty uses PageVisibility API to handle timeout.
     * To ensure that users do not miss their notifications.
     *
     * @param bool $visibilityControl Whether to use visibility control
     *
     * @return self The builder instance
     */
    public function visibilityControl(bool $visibilityControl): self
    {
        $this->option('visibilityControl', $visibilityControl);

        return $this;
    }
}
