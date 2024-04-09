<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\Notification\NotificationInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that a notification contains an option with a specific key, and optionally, a specific value.
 */
final class NotificationOption extends Constraint
{
    /**
     * @param string $expectedKey   the expected option key
     * @param mixed  $expectedValue The expected value for the option
     */
    public function __construct(private readonly string $expectedKey, private readonly mixed $expectedValue = null)
    {
    }

    public function toString(): string
    {
        $description = sprintf('contains a notification with an option "%s"', $this->expectedKey);

        if ($this->expectedValue) {
            $description .= sprintf(' having the value "%s"', json_encode($this->expectedValue));
        }

        return $description;
    }

    protected function matches(mixed $other): bool
    {
        if (!$other instanceof NotificationEvents) {
            return false;
        }

        foreach ($other->getNotifications() as $notification) {
            if ($this->isOptionMatching($notification)) {
                return true;
            }
        }

        return false;
    }

    private function isOptionMatching(NotificationInterface $notification): bool
    {
        $options = $notification->getOptions();

        return isset($options[$this->expectedKey]) && $options[$this->expectedKey] === $this->expectedValue;
    }

    protected function failureDescription(mixed $other): string
    {
        $actualOptions = [];
        if ($other instanceof NotificationEvents) {
            foreach ($other->getNotifications() as $notification) {
                $actualOptions[] = json_encode($notification->getOptions());
            }
        }

        $actualOptionsString = implode('; ', $actualOptions) ?: 'none found';
        $expectation = $this->toString();

        return "Failed asserting that NotificationEvents $expectation. Actual options: [$actualOptionsString].";
    }
}
