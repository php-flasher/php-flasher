<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

/**
 * NotyfBuilder - Builder implementation for Notyf.js notifications.
 *
 * This class provides a fluent interface for configuring Notyf.js notifications.
 * It extends the core notification builder with Notyf-specific options and
 * features, focusing on Notyf's minimalist approach with fewer options than other
 * notification libraries.
 *
 * Design patterns:
 * - Builder: Provides a fluent interface for constructing complex objects
 * - Fluent Interface: Methods return $this for method chaining
 * - Type Safety: Uses PHPStan annotations for compile-time type checking
 *
 * @phpstan-type NotificationType "success"|"info"|"warning"|"error"
 * @phpstan-type OptionsType array{
 *     duration?: int,
 *     ripple?: bool,
 *     position?: array{
 *         x: "left"|"center"|"right",
 *         y: "top"|"center"|"bottom",
 *     },
 *     dismissible?: bool,
 *     background?: string,
 * }
 */
final class NotyfBuilder extends NotificationBuilder
{
    /**
     * Sets the notification display duration.
     *
     * Number of milliseconds before hiding the notification. Use 0 for infinite duration.
     *
     * @param int $duration Duration in milliseconds
     *
     * @return self The builder instance
     */
    public function duration(int $duration): self
    {
        $this->option('duration', $duration);

        return $this;
    }

    /**
     * Sets whether to show the notification with a ripple effect.
     *
     * @param bool $ripple Whether to enable ripple effect
     *
     * @return self The builder instance
     */
    public function ripple(bool $ripple = true): self
    {
        $this->option('ripple', $ripple);

        return $this;
    }

    /**
     * Sets the notification position in the viewport.
     *
     * Viewport location where notifications are rendered.
     *
     * @param "x"|"y"                                $position Specifies the axis: 'x' for horizontal, 'y' for vertical
     * @param "left"|"center"|"right"|"top"|"bottom" $value    Position value, dependent on the axis:
     *                                                         - If $position is 'x', $value must be 'left', 'center' or 'right'
     *                                                         - If $position is 'y', $value must be 'top', 'center' or 'bottom'
     *
     * @phpstan-param ($position is 'x' ? "left"|"center"|"right" : "top"|"center"|"bottom") $value
     *
     * @return self The builder instance
     */
    public function position(string $position, string $value): self
    {
        $option = $this->getEnvelope()->getOption('position', []);
        $option[$position] = $value; // @phpstan-ignore-line

        $this->option('position', $option);

        return $this;
    }

    /**
     * Sets whether to allow users to dismiss the notification.
     *
     * Whether to allow users to dismiss the notification with a button.
     *
     * @param bool $dismissible Whether to make the notification dismissible
     *
     * @return self The builder instance
     */
    public function dismissible(bool $dismissible): self
    {
        $this->option('dismissible', $dismissible);

        return $this;
    }

    /**
     * Sets the background color of the notification.
     *
     * @param string $background CSS color value for the notification background
     *
     * @return self The builder instance
     */
    public function background(string $background): self
    {
        $this->option('background', $background);

        return $this;
    }
}
