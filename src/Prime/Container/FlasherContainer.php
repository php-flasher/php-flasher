<?php

declare(strict_types=1);

namespace Flasher\Prime\Container;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;

final class FlasherContainer
{
    private static ?self $instance = null;

    private function __construct(private readonly ContainerInterface $container)
    {
    }

    public static function getInstance(): self
    {
        if (!self::$instance instanceof self) {
            throw new \LogicException('Container is not initialized yet. Use FlasherContainer::init().');
        }

        return self::$instance;
    }

    public static function init(ContainerInterface $container): void
    {
        self::$instance ??= new self($container);
    }

    public function create(string $id): FlasherInterface|NotificationFactoryInterface
    {
        $factory = $this->container->get($id);
        if ($factory instanceof FlasherInterface) {
            return $factory;
        }

        if ($factory instanceof NotificationFactoryInterface) {
            return $factory;
        }

        throw new \InvalidArgumentException(sprintf('Factory must be an instance of %s or %s.', FlasherInterface::class, NotificationFactoryInterface::class));

        return $factory;
    }
}
