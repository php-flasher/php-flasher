<?php

declare(strict_types=1);

namespace Flasher\Prime\Container;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use Psr\Container\ContainerInterface;

/**
 * FlasherContainer - Service locator for PHPFlasher services using PSR-11 containers.
 *
 * This class provides static access to Flasher services through a PSR-11 compatible
 * container. It manages a singleton instance that wraps the container and provides
 * type-safe access to Flasher services.
 *
 * Design patterns:
 * - Service Locator: Provides a centralized registry for accessing services
 * - Singleton: Maintains a single, global instance of the container wrapper
 * - Adapter: Adapts a PSR-11 container to provide Flasher-specific service access
 *
 * @internal This class is not part of the public API and may change without notice
 */
final class FlasherContainer
{
    /**
     * The singleton instance of this class.
     */
    private static ?self $instance = null;

    /**
     * Private constructor to prevent direct instantiation.
     *
     * @param ContainerInterface|\Closure $container A ContainerInterface instance or factory
     */
    private function __construct(private readonly ContainerInterface|\Closure $container)
    {
    }

    /**
     * Initializes the container with a PSR-11 container or a factory.
     *
     * This method initializes the singleton instance if it doesn't exist yet.
     * It accepts either a direct ContainerInterface implementation or a closure
     * that will return one when invoked.
     *
     * @param ContainerInterface|\Closure $container A ContainerInterface instance or factory
     */
    public static function from(ContainerInterface|\Closure $container): void
    {
        self::$instance ??= new self($container);
    }

    /**
     * Resets the container instance.
     *
     * This method clears the singleton instance, effectively removing all
     * service references. Useful for testing or situations that require
     * container replacement.
     */
    public static function reset(): void
    {
        self::$instance = null;
    }

    /**
     * Creates and returns an instance of a Flasher service by ID.
     *
     * This method retrieves a service from the container and ensures it
     * implements the appropriate interface. It provides type-safe access
     * to various Flasher services with PHPStan return type specifications.
     *
     * @param string $id The service identifier (e.g., 'flasher', 'flasher.toastr')
     *
     * @return FlasherInterface|NotificationFactoryInterface The requested service
     *
     * @throws \InvalidArgumentException If the service doesn't exist or has an invalid type
     *
     * @phpstan-return ($id is 'flasher' ? \Flasher\Prime\FlasherInterface :
     *          ($id is 'flasher.noty' ? \Flasher\Noty\Prime\NotyInterface :
     *          ($id is 'flasher.notyf' ? \Flasher\Notyf\Prime\NotyfInterface :
     *          ($id is 'flasher.sweetalert' ? \Flasher\SweetAlert\Prime\SweetAlertInterface :
     *          ($id is 'flasher.toastr' ? \Flasher\Toastr\Prime\ToastrInterface :
     *                  \Flasher\Prime\Factory\NotificationFactoryInterface)))))
     */
    public static function create(string $id): FlasherInterface|NotificationFactoryInterface
    {
        if (!self::has($id)) {
            throw new \InvalidArgumentException(\sprintf('The container does not have the requested service "%s".', $id));
        }

        $factory = self::getContainer()->get($id);

        if (!$factory instanceof FlasherInterface && !$factory instanceof NotificationFactoryInterface) {
            throw new \InvalidArgumentException(\sprintf('Expected an instance of "%s" or "%s", got "%s".', FlasherInterface::class, NotificationFactoryInterface::class, get_debug_type($factory)));
        }

        return $factory;
    }

    /**
     * Checks if a service exists in the container.
     *
     * @param string $id The service identifier
     *
     * @return bool True if the service exists, false otherwise
     */
    public static function has(string $id): bool
    {
        return self::getContainer()->has($id);
    }

    /**
     * Retrieves the container, resolving it if necessary.
     *
     * If the container was provided as a factory closure, this method
     * invokes it to get the actual container instance.
     *
     * @return ContainerInterface The resolved container instance
     *
     * @throws \InvalidArgumentException If the resolved container is not a ContainerInterface
     */
    public static function getContainer(): ContainerInterface
    {
        $container = self::getInstance()->container;

        $resolved = $container instanceof \Closure || \is_callable($container) ? $container() : $container;

        if (!$resolved instanceof ContainerInterface) {
            throw new \InvalidArgumentException(\sprintf('Expected an instance of "%s", got "%s".', ContainerInterface::class, get_debug_type($resolved)));
        }

        return $resolved;
    }

    /**
     * Retrieves the singleton instance, throws if not initialized.
     *
     * @return self The singleton instance
     *
     * @throws \LogicException If the instance hasn't been initialized yet
     */
    private static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            throw new \LogicException('FlasherContainer has not been initialized. Please initialize it by calling FlasherContainer::from(ContainerInterface $container).');
        }

        return self::$instance;
    }
}
