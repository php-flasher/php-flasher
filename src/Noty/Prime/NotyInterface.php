<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;

/**
 * NotyInterface - Contract for Noty notification factories.
 *
 * This interface defines the contract for Noty notification factories.
 * It extends the core notification factory interface to ensure compatibility
 * with PHPFlasher's notification system, while allowing IDE completion for
 * Noty-specific methods through the mixin annotation.
 *
 * Design patterns:
 * - Interface Segregation: Provides a specific interface for Noty functionality
 * - Contract: Defines a contract for creating Noty notifications
 *
 * @mixin \Flasher\Noty\Prime\NotyBuilder
 */
interface NotyInterface extends NotificationFactoryInterface
{
}
