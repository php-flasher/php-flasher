<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Validates that at least one notification contains a specific message.
 */
final class NotificationMessage extends Constraint
{
    public function __construct(private readonly string $expectedMessage)
    {
    }

    public function toString(): string
    {
        return sprintf('contains a notification with message "%s"', $this->expectedMessage);
    }

    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getNotifications() as $notification) {
            if (str_contains($notification->getMessage(), $this->expectedMessage)) {
                return true;
            }
        }

        return false;
    }

    protected function failureDescription(mixed $other): string
    {
        if (!$other instanceof NotificationEvents) {
            return 'Expected an instance of NotificationEvents but received a different type.';
        }

        $foundMessages = array_map(function (NotificationInterface $notification) {
            return sprintf('"%s"', $notification->getMessage());
        }, $other->getNotifications());

        if (empty($foundMessages)) {
            return sprintf(
                'Expected to find a notification with a message containing "%s", but no notifications were found.',
                $this->expectedMessage
            );
        }

        return sprintf(
            'Expected to find a notification with a message containing "%s". Found messages: %s.',
            $this->expectedMessage,
            implode(', ', $foundMessages)
        );
    }
}
