<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that at least one notification contains a specific title.
 */
final class NotificationTitle extends Constraint
{
    /**
     * @param string $expectedTitle the title content to search for within notifications
     */
    public function __construct(private readonly string $expectedTitle)
    {
    }

    public function toString(): string
    {
        return sprintf('contains a notification with a title containing "%s"', $this->expectedTitle);
    }

    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getNotifications() as $notification) {
            if (str_contains($notification->getTitle(), $this->expectedTitle)) {
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

        $foundTitles = array_map(function (NotificationInterface $notification) {
            return sprintf('"%s"', $notification->getTitle());
        }, $other->getNotifications());

        if (empty($foundTitles)) {
            return sprintf(
                'Expected to find a notification with a title containing "%s", but no notifications were found.',
                $this->expectedTitle
            );
        }

        return sprintf(
            'Expected to find a notification with a title containing "%s". Found titles: %s.',
            $this->expectedTitle,
            implode(', ', $foundTitles)
        );
    }
}
