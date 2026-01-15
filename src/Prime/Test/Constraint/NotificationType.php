<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

final class NotificationType extends Constraint
{
    public function __construct(private readonly string $expectedType)
    {
    }

    public function toString(): string
    {
        return \sprintf('contains a notification of type "%s".', $this->expectedType);
    }

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
     * @param NotificationEvents $other
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
