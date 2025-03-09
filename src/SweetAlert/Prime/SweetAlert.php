<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * SweetAlert - Factory implementation for SweetAlert2 notifications.
 *
 * This class implements the notification factory for SweetAlert2, creating
 * specialized notification builders configured for SweetAlert2's extensive feature set.
 * It serves as the primary entry point for creating SweetAlert notifications.
 *
 * Design patterns:
 * - Factory: Creates specialized notification builders
 * - Bridge: Connects PHPFlasher's notification system to SweetAlert2
 * - Composition: Delegates to SweetAlertBuilder for construction details
 *
 * @mixin \Flasher\SweetAlert\Prime\SweetAlertBuilder
 */
final class SweetAlert extends NotificationFactory implements SweetAlertInterface
{
    /**
     * {@inheritdoc}
     *
     * Creates a new SweetAlert-specific notification builder.
     *
     * @return SweetAlertBuilder A builder configured for SweetAlert2 notifications
     */
    public function createNotificationBuilder(): SweetAlertBuilder
    {
        return new SweetAlertBuilder('sweetalert', $this->storageManager);
    }
}
