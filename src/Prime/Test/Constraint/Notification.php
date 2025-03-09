<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Notification - PHPUnit constraint for asserting complete notification properties.
 *
 * This constraint verifies that a NotificationEvents collection contains at least
 * one notification matching a combination of type, message, title, and options.
 * It allows for comprehensive notification assertions by checking multiple properties.
 *
 * Design patterns:
 * - Composite: Part of PHPUnit's constraint composition system
 * - Strategy: Implements a specific assertion strategy
 * - Specification: Represents a specification that notifications can satisfy
 */
final class Notification extends Constraint
{
    /**
     * Creates a new Notification constraint.
     *
     * @param string               $expectedType    Expected notification type (e.g., 'success', 'error')
     * @param string|null          $expectedMessage Expected message content (null to ignore)
     * @param array<string, mixed> $expectedOptions Expected options as an associative array
     * @param string|null          $expectedTitle   Expected title content (null to ignore)
     */
    public function __construct(
        private readonly string $expectedType,
        private readonly ?string $expectedMessage = null,
        private readonly array $expectedOptions = [],
        private readonly ?string $expectedTitle = null,
    ) {
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string The constraint description
     */
    public function toString(): string
    {
        $details = [
            \sprintf('type: "%s"', $this->expectedType),
        ];

        if (null !== $this->expectedMessage) {
            $details[] = \sprintf('message: "%s"', $this->expectedMessage);
        }

        if (null !== $this->expectedTitle) {
            $details[] = \sprintf('title: "%s"', $this->expectedTitle);
        }

        if (!empty($this->expectedOptions)) {
            $details[] = 'options: ['.json_encode($this->expectedOptions).']';
        }

        return 'contains a notification with '.implode(', ', $details);
    }

    /**
     * Evaluates if the given NotificationEvents object contains at least one notification
     * matching all the expected properties.
     *
     * @param NotificationEvents|mixed $other An instance of NotificationEvents to evaluate
     *
     * @return bool True if a matching notification is found
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getEnvelopes() as $notification) {
            if ($this->isNotificationMatching($notification)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if a specific notification matches all expected properties.
     *
     * A notification matches if:
     * - Its type equals the expected type AND
     * - Its message equals the expected message (if provided) AND
     * - Its title equals the expected title (if provided) AND
     * - Its options contain all expected option key-value pairs (if provided)
     *
     * @param NotificationInterface $notification The notification to check
     *
     * @return bool True if the notification matches all criteria
     */
    private function isNotificationMatching(NotificationInterface $notification): bool
    {
        return $notification->getType() === $this->expectedType
            && (null === $this->expectedMessage || $notification->getMessage() === $this->expectedMessage)
            && (null === $this->expectedTitle || $notification->getTitle() === $this->expectedTitle)
            && (empty($this->expectedOptions) || array_intersect_assoc($this->expectedOptions, $notification->getOptions()) === $this->expectedOptions);
    }

    /**
     * Provides a detailed failure description when the constraint fails.
     *
     * This method lists all actual notifications with their properties,
     * making test failures easier to diagnose.
     *
     * @param NotificationEvents $other The evaluated NotificationEvents instance
     *
     * @return string A detailed failure description
     */
    protected function failureDescription(mixed $other): string
    {
        $foundNotifications = array_map(function (NotificationInterface $notification) {
            return \sprintf(
                'type: "%s", title: "%s", message: "%s", options: [%s]',
                $notification->getType(),
                $notification->getTitle(),
                $notification->getMessage(),
                json_encode($notification->getOptions()),
            );
        }, $other->getEnvelopes());

        if (empty($foundNotifications)) {
            $foundNotifications[] = 'No notifications found';
        }

        return \sprintf(
            'Failed asserting that NotificationEvents %s. Found: [%s].',
            $this->toString(),
            implode('; ', $foundNotifications)
        );
    }
}
