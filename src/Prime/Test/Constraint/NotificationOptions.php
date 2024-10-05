<?php

declare(strict_types=1);

namespace Flasher\Prime\Test\Constraint;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that at least one notification contains a set of options.
 */
final class NotificationOptions extends Constraint
{
    /**
     * @param array<string, mixed> $expectedOptions the expected options
     */
    public function __construct(private readonly array $expectedOptions)
    {
    }

    public function toString(): string
    {
        return 'contains a notification with options matching '.json_encode($this->expectedOptions, \JSON_PRETTY_PRINT);
    }

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

    protected function failureDescription(mixed $other): string
    {
        $actualOptions = [];
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
