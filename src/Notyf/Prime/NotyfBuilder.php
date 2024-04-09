<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class NotyfBuilder extends NotificationBuilder
{
    /**
     * Number of miliseconds before hiding the notification. Use 0 for infinite duration.
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
     * @param "x"|"y"                                $position
     * @param "left"|"center"|"right"|"top"|"bottom" $value
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
}
