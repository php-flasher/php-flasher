<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Checks for the existence of a notification with specified details.
 */
final class Notification extends Constraint
{
    /**
     * Constructor to initialize notification expectations.
     *
     * @param string               $expectedType    expected type of the notification
     * @param string|null          $expectedMessage expected message content
     * @param array<string, mixed> $expectedOptions expected options array
     * @param string|null          $expectedTitle   expected title of the notification
     */
    public function __construct(
        private readonly string $expectedType,
        private readonly ?string $expectedMessage = null,
        private readonly array $expectedOptions = [],
        private readonly ?string $expectedTitle = null,
    ) {
    }

    public function toString(): string
    {
        $details = [
            sprintf('type: "%s"', $this->expectedType),
        ];

        if (null !== $this->expectedMessage) {
            $details[] = sprintf('message: "%s"', $this->expectedMessage);
        }

        if (null !== $this->expectedTitle) {
            $details[] = sprintf('title: "%s"', $this->expectedTitle);
        }

        if (!empty($this->expectedOptions)) {
            $details[] = 'options: ['.json_encode($this->expectedOptions).']';
        }

        return 'contains a notification with '.implode(', ', $details);
    }

    /**
     * @param NotificationEvents|mixed $other
     */
    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getNotifications() as $notification) {
            if ($this->isNotificationMatching($notification)) {
                return true;
            }
        }

        return false;
    }

    private function isNotificationMatching(NotificationInterface $notification): bool
    {
        return $notification->getType() === $this->expectedType
            && (null === $this->expectedMessage || $notification->getMessage() === $this->expectedMessage)
            && (null === $this->expectedTitle || $notification->getTitle() === $this->expectedTitle)
            && (empty($this->expectedOptions) || array_intersect_assoc($this->expectedOptions, $notification->getOptions()) === $this->expectedOptions);
    }

    /**
     * @param NotificationEvents $other
     */
    protected function failureDescription(mixed $other): string
    {
        $foundNotifications = array_map(function (NotificationInterface $notification) {
            return sprintf(
                'type: "%s", title: "%s", message: "%s", options: [%s]',
                $notification->getType(),
                $notification->getTitle(),
                $notification->getMessage(),
                json_encode($notification->getOptions()),
            );
        }, $other->getNotifications());

        if (empty($foundNotifications)) {
            $foundNotifications[] = 'No notifications found';
        }

        return sprintf(
            'Failed asserting that NotificationEvents %s. Found: [%s].',
            $this->toString(),
            implode('; ', $foundNotifications)
        );
    }
}
