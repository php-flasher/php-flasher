<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * PresenterStamp - Controls which presenters can render a notification.
 *
 * This stamp restricts which presenters can render a notification by specifying
 * a regex pattern. Only presenters whose names match the pattern will be allowed
 * to render the notification. This is useful for creating notifications that
 * are only meant for specific presentation formats.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Filter: Restricts which presenters can render a notification
 */
final readonly class PresenterStamp implements StampInterface
{
    /**
     * Creates a new PresenterStamp instance.
     *
     * @param string $pattern A regex pattern that presenter names must match
     *
     * @throws \InvalidArgumentException If the provided pattern is not a valid regex
     */
    public function __construct(private string $pattern)
    {
        if (false === @preg_match($pattern, '')) {
            throw new \InvalidArgumentException(\sprintf("The provided regex pattern '%s' is invalid for the presenter stamp. Please ensure it is a valid regex expression.", $pattern));
        }
    }

    /**
     * Gets the pattern value.
     *
     * @return string The regex pattern
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }
}
