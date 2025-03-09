<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * NotificationMessage - PHPUnit constraint for asserting notification message presence.
 *
 * This constraint verifies that a NotificationEvents collection contains at least
 * one notification with a message containing the expected text. It's used by the
 * FlasherAssert class for message-related assertions.
 *
 * Design patterns:
 * - Composite: Part of PHPUnit's constraint composition system
 * - Strategy: Implements a specific assertion strategy
 * - String Matcher: Performs string matching on notification messages
 */
final class NotificationMessage extends Constraint
{
    /**
     * Creates a new NotificationMessage constraint.
     *
     * @param string $expectedMessage The expected message text (or substring)
     */
    public function __construct(private readonly string $expectedMessage)
    {
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string The constraint description
     */
    public function toString(): string
    {
        return \sprintf('contains a notification with message "%s"', $this->expectedMessage);
    }

    /**
     * Evaluates if the given NotificationEvents object contains at least one notification
     * with a message containing the expected text.
     *
     * @param NotificationEvents|mixed $other An instance of NotificationEvents to evaluate
     *
     * @return bool True if a notification with the expected message text is found
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getEnvelopes() as $notification) {
            if (str_contains($notification->getMessage(), $this->expectedMessage)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Provides a detailed failure description when the constraint fails.
     *
     * This method lists all actual notification messages found, making
     * test failures easier to diagnose.
     *
     * @param NotificationEvents $other The evaluated NotificationEvents instance
     *
     * @return string A detailed failure description
     */
    protected function failureDescription(mixed $other): string
    {
        // @phpstan-ignore-next-line
        if (!$other instanceof NotificationEvents) {
            return 'Expected an instance of NotificationEvents but received a different type.';
        }

        $foundMessages = array_map(function (NotificationInterface $notification) {
            return \sprintf('"%s"', $notification->getMessage());
        }, $other->getEnvelopes());

        if (empty($foundMessages)) {
            return \sprintf(
                'Expected to find a notification with a message containing "%s", but no notifications were found.',
                $this->expectedMessage
            );
        }

        return \sprintf(
            'Expected to find a notification with a message containing "%s". Found messages: %s.',
            $this->expectedMessage,
            implode(', ', $foundMessages)
        );
    }
}
