<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

/**
 * Interface for the notification factory locator service.
 *
 * This interface defines the contract for a service that locates and
 * provides notification factories by their identifiers. It allows the
 * system to resolve factories at runtime without directly coupling to
 * specific implementations.
 *
 * Design pattern: Service Locator - Provides a centralized registry
 * for finding and accessing services.
 */
interface NotificationFactoryLocatorInterface
{
    /**
     * Checks if a notification factory exists for the given identifier.
     *
     * @param string $id The identifier to check
     *
     * @return bool True if a factory exists for the given identifier, false otherwise
     */
    public function has(string $id): bool;

    /**
     * Gets a notification factory by its identifier.
     *
     * @param string $id The identifier for the factory to retrieve
     *
     * @return NotificationFactoryInterface The requested notification factory
     *
     * @throws \Flasher\Prime\Exception\FactoryNotFoundException If no factory is registered with the given identifier
     *
     * @phpstan-return ($id is 'flasher' ? \Flasher\Prime\Factory\FlasherFactoryInterface :
     *          ($id is 'noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($id is 'notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($id is 'sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($id is 'toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public function get(string $id): NotificationFactoryInterface;
}
