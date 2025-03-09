<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * Notyf - Factory implementation for Notyf.js notifications.
 *
 * This class implements the notification factory for Notyf.js, creating
 * specialized notification builders configured for Notyf's specific features.
 * It serves as the primary entry point for creating Notyf notifications.
 *
 * Design patterns:
 * - Factory: Creates specialized notification builders
 * - Bridge: Connects PHPFlasher's notification system to Notyf.js
 * - Composition: Delegates to NotyfBuilder for construction details
 *
 * @mixin \Flasher\Notyf\Prime\NotyfBuilder
 */
final class Notyf extends NotificationFactory implements NotyfInterface
{
    /**
     * {@inheritdoc}
     *
     * Creates a new Notyf-specific notification builder.
     *
     * @return NotyfBuilder A builder configured for Notyf.js notifications
     */
    public function createNotificationBuilder(): NotyfBuilder
    {
        return new NotyfBuilder('notyf', $this->storageManager);
    }
}
