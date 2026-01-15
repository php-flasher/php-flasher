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
    public function duration(int $duration): self
    {
        $this->option('duration', $duration);

        return $this;
    }

    public function ripple(bool $ripple = true): self
    {
        $this->option('ripple', $ripple);

        return $this;
    }

    /**
     * @phpstan-param ($position is 'x' ? "left"|"center"|"right" : "top"|"center"|"bottom") $value
     */
    public function position(string $position, string $value): self
    {
        $option = $this->getEnvelope()->getOption('position', []);
        $option[$position] = $value; // @phpstan-ignore-line

        $this->option('position', $option);

        return $this;
    }

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
