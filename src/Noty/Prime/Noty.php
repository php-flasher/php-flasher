<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\NotificationFactory;

/**
 * Noty - Factory implementation for Noty.js notifications.
 *
 * This class implements the notification factory for Noty.js, creating
 * specialized notification builders configured for Noty's specific features.
 * It serves as the primary entry point for creating Noty notifications.
 *
 * Design patterns:
 * - Factory: Creates specialized notification builders
 * - Bridge: Connects PHPFlasher's notification system to Noty.js
 * - Composition: Delegates to NotyBuilder for construction details
 *
 * @mixin \Flasher\Noty\Prime\NotyBuilder
 */
final class Noty extends NotificationFactory implements NotyInterface
{
    /**
     * {@inheritdoc}
     *
     * Creates a new Noty-specific notification builder.
     *
     * @return NotyBuilder A builder configured for Noty.js notifications
     */
    public function createNotificationBuilder(): NotyBuilder
    {
        return new NotyBuilder('noty', $this->storageManager);
    }
}
