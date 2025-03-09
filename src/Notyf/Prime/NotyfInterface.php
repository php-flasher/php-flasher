<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;

/**
 * NotyfInterface - Contract for Notyf notification factories.
 *
 * This interface defines the contract for Notyf notification factories.
 * It extends the core notification factory interface to ensure compatibility
 * with PHPFlasher's notification system, while allowing IDE completion for
 * Notyf-specific methods through the mixin annotation.
 *
 * Design patterns:
 * - Interface Segregation: Provides a specific interface for Notyf functionality
 * - Contract: Defines a contract for creating Notyf notifications
 *
 * @mixin \Flasher\Notyf\Prime\NotyfBuilder
 */
interface NotyfInterface extends NotificationFactoryInterface
{
}
