<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * WhenStamp - Controls conditional display of notifications.
 *
 * This stamp provides a way to conditionally display notifications based on
 * a boolean condition. If the condition is true, the notification will be
 * displayed, otherwise it will be suppressed.
 *
 * Design pattern: Specification - Encapsulates a business rule as a value object
 */
final readonly class WhenStamp implements StampInterface
{
    /**
     * Creates a new WhenStamp instance.
     *
     * @param bool $condition When true, the notification will be displayed
     */
    public function __construct(private bool $condition)
    {
    }

    /**
     * Gets the condition value.
     *
     * @return bool True if the notification should be displayed, false otherwise
     */
    public function getCondition(): bool
    {
        return $this->condition;
    }
}
