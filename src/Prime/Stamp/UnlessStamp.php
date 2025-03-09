<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * UnlessStamp - Controls conditional suppression of notifications.
 *
 * This stamp provides a way to conditionally suppress notifications based on
 * a boolean condition. If the condition is true, the notification will be
 * suppressed, otherwise it will be displayed.
 *
 * Design pattern: Specification - Encapsulates a business rule as a value object
 */
final readonly class UnlessStamp implements StampInterface
{
    /**
     * Creates a new UnlessStamp instance.
     *
     * @param bool $condition When true, the notification will be suppressed
     */
    public function __construct(private bool $condition)
    {
    }

    /**
     * Gets the condition value.
     *
     * @return bool True if the notification should be suppressed, false otherwise
     */
    public function getCondition(): bool
    {
        return $this->condition;
    }
}
