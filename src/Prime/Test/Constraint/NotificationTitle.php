<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * NotificationTitle - PHPUnit constraint for asserting notification title presence.
 *
 * This constraint verifies that a NotificationEvents collection contains at least
 * one notification with a title containing the expected text. It's used by the
 * FlasherAssert class for title-related assertions.
 *
 * Design patterns:
 * - Composite: Part of PHPUnit's constraint composition system
 * - Strategy: Implements a specific assertion strategy
 * - String Matcher: Performs string matching on notification titles
 */
final class NotificationTitle extends Constraint
{
    /**
     * Creates a new NotificationTitle constraint.
     *
     * @param string $expectedTitle The expected title text (or substring)
     */
    public function __construct(private readonly string $expectedTitle)
    {
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string The constraint description
     */
    public function toString(): string
    {
        return \sprintf('contains a notification with a title containing "%s"', $this->expectedTitle);
    }

    /**
     * Evaluates if the given NotificationEvents object contains at least one notification
     * with a title containing the expected text.
     *
     * @param NotificationEvents|mixed $other An instance of NotificationEvents to evaluate
     *
     * @return bool True if a notification with the expected title text is found
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getEnvelopes() as $notification) {
            if (str_contains($notification->getTitle(), $this->expectedTitle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Provides a detailed failure description when the constraint fails.
     *
     * This method lists all actual notification titles found, making
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

        $foundTitles = array_map(function (NotificationInterface $notification) {
            return \sprintf('"%s"', $notification->getTitle());
        }, $other->getEnvelopes());

        if (empty($foundTitles)) {
            return \sprintf(
                'Expected to find a notification with a title containing "%s", but no notifications were found.',
                $this->expectedTitle
            );
        }

        return \sprintf(
            'Expected to find a notification with a title containing "%s". Found titles: %s.',
            $this->expectedTitle,
            implode(', ', $foundTitles)
        );
    }
}
