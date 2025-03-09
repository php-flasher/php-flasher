<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

/**
 * Type - Constants for standard notification types.
 *
 * This class defines the standard notification types supported by PHPFlasher.
 * Using these constants instead of string literals ensures consistency and
 * prevents typos when specifying notification types.
 */
final class Type
{
    /**
     * Success notification type.
     *
     * Used for positive feedback, successful operations, or completed actions.
     */
    public const SUCCESS = 'success';

    /**
     * Error notification type.
     *
     * Used for failures, exceptions, or problems that prevented an operation from completing.
     */
    public const ERROR = 'error';

    /**
     * Info notification type.
     *
     * Used for neutral informational messages, status updates, or helpful tips.
     */
    public const INFO = 'info';

    /**
     * Warning notification type.
     *
     * Used for potential issues, alerts, or important notices that don't prevent
     * an operation but deserve attention.
     */
    public const WARNING = 'warning';
}
