<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * Toastr - Factory implementation for Toastr.js notifications.
 *
 * This class implements the notification factory for Toastr.js, creating
 * specialized notification builders configured for Toastr's extensive feature set.
 * It serves as the primary entry point for creating Toastr notifications.
 *
 * Design patterns:
 * - Factory: Creates specialized notification builders
 * - Bridge: Connects PHPFlasher's notification system to Toastr.js
 * - Composition: Delegates to ToastrBuilder for construction details
 *
 * @mixin \Flasher\Toastr\Prime\ToastrBuilder
 */
final class Toastr extends NotificationFactory implements ToastrInterface
{
    /**
     * {@inheritdoc}
     *
     * Creates a new Toastr-specific notification builder.
     *
     * @return ToastrBuilder A builder configured for Toastr.js notifications
     */
    public function createNotificationBuilder(): ToastrBuilder
    {
        return new ToastrBuilder('toastr', $this->storageManager);
    }
}
