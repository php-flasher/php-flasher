<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;

/**
 * SweetAlertInterface - Contract for SweetAlert notification factories.
 *
 * This interface defines the contract for SweetAlert notification factories.
 * It extends the core notification factory interface to ensure compatibility
 * with PHPFlasher's notification system, while allowing IDE completion for
 * SweetAlert-specific methods through the mixin annotation.
 *
 * Design patterns:
 * - Interface Segregation: Provides a specific interface for SweetAlert functionality
 * - Contract: Defines a contract for creating SweetAlert notifications
 *
 * @mixin \Flasher\SweetAlert\Prime\SweetAlertBuilder
 */
interface SweetAlertInterface extends NotificationFactoryInterface
{
}
