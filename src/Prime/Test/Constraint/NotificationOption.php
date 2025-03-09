<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * NotificationOption - PHPUnit constraint for asserting a specific notification option.
 *
 * This constraint verifies that a NotificationEvents collection contains at least
 * one notification with a specific option key and optionally a specific value. It's
 * used by the FlasherAssert class for option-specific assertions.
 *
 * Design patterns:
 * - Composite: Part of PHPUnit's constraint composition system
 * - Strategy: Implements a specific assertion strategy
 * - Key-Value Matcher: Performs key-value matching on notification options
 */
final class NotificationOption extends Constraint
{
    /**
     * Creates a new NotificationOption constraint.
     *
     * @param string $expectedKey   The expected option key
     * @param mixed  $expectedValue The expected option value (null to check only key existence)
     */
    public function __construct(private readonly string $expectedKey, private readonly mixed $expectedValue = null)
    {
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string The constraint description
     */
    public function toString(): string
    {
        $description = \sprintf('contains a notification with an option "%s"', $this->expectedKey);

        if ($this->expectedValue) {
            $description .= \sprintf(' having the value "%s"', json_encode($this->expectedValue));
        }

        return $description;
    }

    /**
     * Evaluates if the given NotificationEvents object contains at least one notification
     * with the expected option key and value.
     *
     * @param NotificationEvents|mixed $other An instance of NotificationEvents to evaluate
     *
     * @return bool True if a notification with the expected option is found
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getEnvelopes() as $notification) {
            if ($this->isOptionMatching($notification)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if a specific notification has the expected option key and value.
     *
     * @param NotificationInterface $notification The notification to check
     *
     * @return bool True if the notification has the expected option
     */
    private function isOptionMatching(NotificationInterface $notification): bool
    {
        $options = $notification->getOptions();

        return isset($options[$this->expectedKey]) && $options[$this->expectedKey] === $this->expectedValue;
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
        $expectation = $this->toString();

        return "Failed asserting that NotificationEvents $expectation. Actual options: [$actualOptionsString].";
    }
}
