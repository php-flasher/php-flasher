<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * NotificationCount - PHPUnit constraint for asserting notification count.
 *
 * This constraint verifies that a NotificationEvents collection contains
 * exactly the expected number of notifications. It's used by the FlasherAssert
 * class for count-related assertions.
 *
 * Design patterns:
 * - Composite: Part of PHPUnit's constraint composition system
 * - Strategy: Implements a specific assertion strategy
 */
final class NotificationCount extends Constraint
{
    /**
     * Creates a new NotificationCount constraint.
     *
     * @param int $expectedValue The expected number of notifications
     */
    public function __construct(private readonly int $expectedValue)
    {
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string The constraint description
     */
    public function toString(): string
    {
        return \sprintf('matches the expected notification count of %d.', $this->expectedValue);
    }

    /**
     * Evaluates if the given NotificationEvents object matches the expected notification count.
     *
     * @param NotificationEvents|mixed $other An instance of NotificationEvents to evaluate
     *
     * @return bool True if the actual count matches the expected count
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        return $this->expectedValue === $this->countNotifications($other);
    }

    /**
     * Provides a detailed failure description when the constraint fails.
     *
     * @param NotificationEvents $other The evaluated NotificationEvents instance
     *
     * @return string A detailed failure description
     */
    protected function failureDescription(mixed $other): string
    {
        $actualCount = $this->countNotifications($other);

        return \sprintf('Expected the notification count to be %d, but got %d instead.', $this->expectedValue, $actualCount);
    }

    /**
     * Counts the notifications in the given NotificationEvents object.
     *
     * @param NotificationEvents $events The NotificationEvents instance
     *
     * @return int The number of notifications
     */
    private function countNotifications(NotificationEvents $events): int
    {
        return \count($events->getEnvelopes());
    }
}
