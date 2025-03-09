<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * NotificationType - PHPUnit constraint for asserting notification type presence.
 *
 * This constraint verifies that a NotificationEvents collection contains at least
 * one notification of the specified type. It's used by the FlasherAssert class
 * for type-related assertions.
 *
 * Design patterns:
 * - Composite: Part of PHPUnit's constraint composition system
 * - Strategy: Implements a specific assertion strategy
 */
final class NotificationType extends Constraint
{
    /**
     * Creates a new NotificationType constraint.
     *
     * @param string $expectedType The expected notification type (e.g., 'success', 'error')
     */
    public function __construct(private readonly string $expectedType)
    {
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string The constraint description
     */
    public function toString(): string
    {
        return \sprintf('contains a notification of type "%s".', $this->expectedType);
    }

    /**
     * Evaluates if the given NotificationEvents object contains at least one notification
     * of the expected type.
     *
     * @param NotificationEvents|mixed $other An instance of NotificationEvents to evaluate
     *
     * @return bool True if a notification of the expected type is found
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getEnvelopes() as $notification) {
            if ($notification->getType() === $this->expectedType) {
                return true;
            }
        }

        return false;
    }

    /**
     * Provides a detailed failure description when the constraint fails.
     *
     * This method provides context about what types were found instead of
     * the expected type, making test failures easier to diagnose.
     *
     * @param NotificationEvents $other The evaluated NotificationEvents instance
     *
     * @return string A detailed failure description
     */
    protected function failureDescription(mixed $other): string
    {
        $actualTypes = array_map(function (NotificationInterface $notification) {
            return $notification->getType();
        }, $other->getEnvelopes());

        $uniqueTypes = array_unique($actualTypes);
        $typesList = implode(', ', $uniqueTypes);

        return \sprintf(
            'Expected the NotificationEvents to contain a notification of type "%s", but found types: %s.',
            $this->expectedType,
            $typesList ?: 'none'
        );
    }
}
