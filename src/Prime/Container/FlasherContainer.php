<?php

declare(strict_types=1);

namespace Flasher\Prime\Container;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use Psr\Container\ContainerInterface;

/**
 * Manages and provides access to Flasher service instances using a PSR-11 compatible container.
 * Allows initializing the internal container using a direct instance, a Closure, or a callable
 * that returns a ContainerInterface instance.
 *
 * @internal
 */
final class FlasherContainer
{
    private static ?self $instance = null;

    private function __construct(private readonly ContainerInterface|\Closure $container)
    {
    }

    /**
     * Initializes the container with a direct ContainerInterface or a Closure/callable that resolves to one.
     *
     * @param ContainerInterface|\Closure $container a ContainerInterface instance or a resolver that returns one
     */
    public static function from(ContainerInterface|\Closure $container): void
    {
        self::$instance ??= new self($container);
    }

    /**
     * Resets the container instance, effectively clearing it.
     */
    public static function reset(): void
    {
        self::$instance = null;
    }

    /**
     * Creates and returns an instance of a service identified by $id.
     * Throws an exception if the service is not found or does not implement the required interfaces.
     *
     * @param string $id the service identifier
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
     * Checks if the container has a service identified by $id.
     *
     * @param string $id the service identifier
     *
     * @return bool true if the service exists, false otherwise
     */
    public static function has(string $id): bool
    {
        return self::getContainer()->has($id);
    }

    /**
     * Retrieves the container, resolving it if necessary.
     *
     * @return ContainerInterface the container instance
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
     * Retrieves the singleton instance of FlasherContainer, throws if not initialized.
     *
     * @return self the singleton instance
     */
    private static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            throw new \LogicException('FlasherContainer has not been initialized. Please initialize it by calling FlasherContainer::from(ContainerInterface $container).');
        }

        return self::$instance;
    }
}
