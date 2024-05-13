<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use PHPUnit\Framework\Constraint\Constraint;

final class NotificationCount extends Constraint
{
    public function __construct(private readonly int $expectedValue)
    {
    }

    public function toString(): string
    {
        return sprintf('matches the expected notification count of %d.', $this->expectedValue);
    }

    /**
     * Evaluates if the given NotificationEvents object matches the expected notification count.
     *
     * @param NotificationEvents|mixed $other an instance of NotificationEvents to evaluate
     *
     * @return bool returns true if the actual notification count matches the expected count
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        return $this->expectedValue === $this->countNotifications($other);
    }

    /**
     * Provides a more detailed and understandable failure description.
     *
     * @param NotificationEvents $other the evaluated NotificationEvents instance
     *
     * @return string returns a detailed failure description
     */
    protected function failureDescription(mixed $other): string
    {
        $actualCount = $this->countNotifications($other);

        return sprintf('Expected the notification count to be %d, but got %d instead.', $this->expectedValue, $actualCount);
    }

    /**
     * Counts the notifications in the given NotificationEvents object.
     *
     * @param NotificationEvents $events the NotificationEvents instance to count notifications from
     *
     * @return int returns the count of notifications
     */
    private function countNotifications(NotificationEvents $events): int
    {
        return \count($events->getNotifications());
    }
}
