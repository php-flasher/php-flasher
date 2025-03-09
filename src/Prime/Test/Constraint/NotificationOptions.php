<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * NotificationOptions - PHPUnit constraint for asserting notification options.
 *
 * This constraint verifies that a NotificationEvents collection contains at least
 * one notification with options matching all the expected key-value pairs. It's used
 * by the FlasherAssert class for options-related assertions.
 *
 * Design patterns:
 * - Composite: Part of PHPUnit's constraint composition system
 * - Strategy: Implements a specific assertion strategy
 * - Key-Value Matcher: Performs associative array matching on notification options
 */
final class NotificationOptions extends Constraint
{
    /**
     * Creates a new NotificationOptions constraint.
     *
     * @param array<string, mixed> $expectedOptions The expected option key-value pairs
     */
    public function __construct(private readonly array $expectedOptions)
    {
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string The constraint description
     */
    public function toString(): string
    {
        return 'contains a notification with options matching '.json_encode($this->expectedOptions, \JSON_PRETTY_PRINT);
    }

    /**
     * Evaluates if the given NotificationEvents object contains at least one notification
     * with options containing all the expected key-value pairs.
     *
     * @param NotificationEvents|mixed $other An instance of NotificationEvents to evaluate
     *
     * @return bool True if a notification with matching options is found
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getEnvelopes() as $notification) {
            if (!array_diff_assoc($this->expectedOptions, $notification->getOptions())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Provides a detailed failure description when the constraint fails.
     *
     * This method lists all actual notification options found, making
     * test failures easier to diagnose.
     *
     * @param NotificationEvents $other The evaluated NotificationEvents instance
     *
     * @return string A detailed failure description
     */
    protected function failureDescription(mixed $other): string
    {
        $actualOptions = [];

        // @phpstan-ignore-next-line
        if ($other instanceof NotificationEvents) {
            foreach ($other->getEnvelopes() as $notification) {
                $actualOptions[] = json_encode($notification->getOptions());
            }
        }

        $actualOptionsString = implode('; ', $actualOptions) ?: 'none found';

        return \sprintf(
            'Failed asserting that NotificationEvents %s. Actual options in notifications: [%s].',
            $this->toString(),
            $actualOptionsString
        );
    }
}
