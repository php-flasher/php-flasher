<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

/**
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
     * Number of milliseconds before hiding the notification. Use 0 for infinite duration.
     */
    public function duration(int $duration): self
    {
        $this->option('duration', $duration);

        return $this;
    }

    /**
     * Whether to show the notification with a ripple effect.
     */
    public function ripple(bool $ripple = true): self
    {
        $this->option('ripple', $ripple);

        return $this;
    }

    /**
     * Viewport location where notifications are rendered.
     *
     * @param "x"|"y"                                $position specifies the axis: 'x' for horizontal, 'y' for vertical
     * @param "left"|"center"|"right"|"top"|"bottom" $value    Position value, dependent on the axis:
     *                                                         - If $position is 'x', $value must be 'left', 'center' or 'right'.
     *                                                         - If $position is 'y', $value must be 'top', 'center' or 'bottom'.
     *
     * @phpstan-param ($position is 'x' ? "left"|"center"|"right" : "top"|"center"|"bottom") $value
     */
    public function position(string $position, string $value): self
    {
        $option = $this->getEnvelope()->getOption('position', []);
        $option[$position] = $value; // @phpstan-ignore-line

        $this->option('position', $option);

        return $this;
    }

    /**
     * Whether to allow users to dismiss the notification with a button.
     */
    public function dismissible(bool $dismissible): self
    {
        $this->option('dismissible', $dismissible);

        return $this;
    }

    public function background(string $background): self
    {
        $this->option('background', $background);

        return $this;
    }
}
