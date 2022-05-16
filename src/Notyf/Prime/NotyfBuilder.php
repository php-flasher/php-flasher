<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class NotyfBuilder extends NotificationBuilder
{
    /**
     * Number of miliseconds before hiding the notification. Use 0 for infinite duration.
     *
     * @param int $duration
     *
     * @return static
     */
    public function duration($duration)
    {
        $this->option('duration', $duration);

        return $this;
    }

    /**
     * Whether to show the notification with a ripple effect.
     *
     * @param bool $ripple
     *
     * @return static
     */
    public function ripple($ripple)
    {
        $this->option('ripple', $ripple);

        return $this;
    }

    /**
     * Viewport location where notifications are rendered.
     *
     * @param string $position
     * @param string $value
     *
     * @return static
     */
    public function position($position, $value)
    {
        $option = $this->getEnvelope()->getOption('position', array());
        $option[$position] = $value; // @phpstan-ignore-line

        $this->option('position', $option);

        return $this;
    }

    /**
     * Whether to allow users to dismiss the notification with a button.
     *
     * @param bool $dismissible
     *
     * @return static
     */
    public function dismissible($dismissible)
    {
        $this->option('dismissible', $dismissible);

        return $this;
    }
}
