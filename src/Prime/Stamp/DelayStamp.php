<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * DelayStamp - Controls notification display delay.
 *
 * This stamp specifies how long to wait (in milliseconds) before displaying
 * a notification. It allows for scheduling notifications to appear after a
 * certain amount of time has passed.
 *
 * Design pattern: Value Object - Immutable object representing a specific concept
 */
final readonly class DelayStamp implements StampInterface
{
    /**
     * Creates a new DelayStamp instance.
     *
     * @param int $delay The delay in milliseconds before displaying the notification
     */
    public function __construct(private int $delay)
    {
    }

    /**
     * Gets the delay value.
     *
     * @return int The delay in milliseconds
     */
    public function getDelay(): int
    {
        return $this->delay;
    }
}
