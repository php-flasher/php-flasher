<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

/**
 * Notification type constants.
 *
 * @phpstan-type NotificationType 'success'|'error'|'info'|'warning'
 */
final class Type
{
    /** @var 'success' */
    public const SUCCESS = 'success';

    /** @var 'error' */
    public const ERROR = 'error';

    /** @var 'info' */
    public const INFO = 'info';

    /** @var 'warning' */
    public const WARNING = 'warning';

    /**
     * Get all available notification types.
     *
     * @return list<NotificationType>
     */
    public static function all(): array
    {
        return [self::SUCCESS, self::ERROR, self::INFO, self::WARNING];
    }

    /**
     * Check if a given type is valid.
     *
     * @phpstan-assert-if-true NotificationType $type
     */
    public static function isValid(string $type): bool
    {
        return \in_array($type, self::all(), true);
    }
}
