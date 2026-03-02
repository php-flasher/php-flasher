<?php

declare(strict_types=1);

namespace Flasher\Prime\Container;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use Psr\Container\ContainerInterface;

/**
 * Service container for PHPFlasher.
 *
 * Provides a static access point to the flasher services.
 * Must be initialized with a PSR-11 container or a closure that returns one.
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
     * Initialize the container with a PSR-11 container or a lazy-loading closure.
     *
     * @param ContainerInterface|\Closure(): ContainerInterface $container
     */
    public static function from(ContainerInterface|\Closure $container): void
    {
        self::$instance ??= new self($container);
    }

    /**
     * Alias for from() - sets the container instance.
     *
     * @param FlasherInterface $flasher The flasher instance to use
     */
    public static function setContainer(FlasherInterface $flasher): void
    {
        self::$instance = new self(new class($flasher) implements ContainerInterface {
            public function __construct(private readonly FlasherInterface $flasher)
            {
            }

            public function get(string $id): FlasherInterface
            {
                return $this->flasher;
            }

            public function has(string $id): bool
            {
                return 'flasher' === $id;
            }
        });
    }

    /**
     * Reset the container instance.
     */
    public static function reset(): void
    {
        self::$instance = null;
    }

    /**
     * Create or retrieve a flasher service from the container.
     *
     * @param string $id The service identifier (e.g., 'flasher', 'flasher.toastr')
     *
     * @throws \InvalidArgumentException If the service is not found or invalid
     * @throws \LogicException           If the container has not been initialized
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
     * Check if a service exists in the container.
     *
     * @param string $id The service identifier
     *
     * @throws \LogicException If the container has not been initialized
     */
    public static function has(string $id): bool
    {
        return self::getContainer()->has($id);
    }

    /**
     * Get the underlying PSR-11 container.
     *
     * @throws \LogicException           If the container has not been initialized
     * @throws \InvalidArgumentException If the container closure returns an invalid type
     */
    public static function getContainer(): ContainerInterface
    {
        $container = self::getInstance()->container;

        $resolved = $container instanceof \Closure ? $container() : $container;

        if (!$resolved instanceof ContainerInterface) {
            throw new \InvalidArgumentException(\sprintf('Expected an instance of "%s", got "%s".', ContainerInterface::class, get_debug_type($resolved)));
        }

        return $resolved;
    }

    private static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            throw new \LogicException('FlasherContainer has not been initialized. Please initialize it by calling FlasherContainer::from(ContainerInterface $container).');
        }

        return self::$instance;
    }
}
