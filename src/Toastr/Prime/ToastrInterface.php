<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;

/**
 * ToastrInterface - Contract for Toastr notification factories.
 *
 * This interface defines the contract for Toastr notification factories.
 * It extends the core notification factory interface to ensure compatibility
 * with PHPFlasher's notification system, while allowing IDE completion for
 * Toastr-specific methods through the mixin annotation.
 *
 * Design patterns:
 * - Interface Segregation: Provides a specific interface for Toastr functionality
 * - Contract: Defines a contract for creating Toastr notifications
 *
 * @mixin \Flasher\Toastr\Prime\ToastrBuilder
 */
interface ToastrInterface extends NotificationFactoryInterface
{
}
