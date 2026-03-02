<?php

declare(strict_types=1);

namespace Flasher\Prime\Container;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use Psr\Container\ContainerInterface;

/**
 * @internal
 */
final class FlasherContainer
{
    private static ?self $instance = null;

    private function __construct(private readonly ContainerInterface|\Closure $container)
    {
    }

    public static function from(ContainerInterface|\Closure $container): void
    {
        self::$instance ??= new self($container);
    }

    public static function reset(): void
    {
        self::$instance = null;
    }

    /**
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

    public static function has(string $id): bool
    {
        return self::getContainer()->has($id);
    }

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
