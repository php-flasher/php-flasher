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
        return \sprintf('matches the expected notification count of %d.', $this->expectedValue);
    }

    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        return $this->expectedValue === $this->countNotifications($other);
    }

    /**
     * @param NotificationEvents $other
     */
    protected function failureDescription(mixed $other): string
    {
        $actualCount = $this->countNotifications($other);

        return \sprintf('Expected the notification count to be %d, but got %d instead.', $this->expectedValue, $actualCount);
    }

    private function countNotifications(NotificationEvents $events): int
    {
        return \count($events->getEnvelopes());
    }
}
