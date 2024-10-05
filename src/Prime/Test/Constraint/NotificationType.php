<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * A constraint that asserts a specific type of notification is present.
 *
 * This constraint checks if among the notifications present, there is at least
 * one of a specified type. This is useful for tests that need to verify the presence
 * of certain types of notifications among those that have been dispatched.
 */
final class NotificationType extends Constraint
{
    public function __construct(private readonly string $expectedType)
    {
    }

    public function toString(): string
    {
        return \sprintf('contains a notification of type "%s".', $this->expectedType);
    }

    /**
     * Evaluates the constraint for the parameter $other.
     * If $other is not an instance of NotificationEvents, the method will return false.
     *
     * @param NotificationEvents|mixed $other value or object to evaluate
     *
     * @return bool true if the constraint is met, false otherwise
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
     * Returns a custom failure description for when the constraint is not met.
     *
     * @param NotificationEvents $other evaluated object or value
     *
     * @return string the failure description
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
