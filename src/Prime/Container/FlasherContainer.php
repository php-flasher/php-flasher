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

    private function __construct(private readonly ContainerInterface $container)
    {
    }

    public static function from(ContainerInterface $container): void
    {
        self::$instance ??= new self($container);
    }

    public static function create(string $id): FlasherInterface|NotificationFactoryInterface
    {
        $instance = self::getInstance();

        $factory = $instance->container->get($id);

        if (!$factory instanceof FlasherInterface && !$factory instanceof NotificationFactoryInterface) {
            throw new \InvalidArgumentException(sprintf('Expected an instance of "%s" or "%s", got "%s".', FlasherInterface::class, NotificationFactoryInterface::class, get_debug_type($factory)));
        }

        return $factory;
    }

    private static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            throw new \LogicException('FlasherContainer has not been initialized. Please initialize it by calling FlasherContainer::from(ContainerInterface $container).');
        }

        return self::$instance;
    }
}
