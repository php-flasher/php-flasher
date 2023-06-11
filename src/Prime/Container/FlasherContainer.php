<?php

declare(strict_types=1);

namespace Flasher\Prime\Container;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;

final class FlasherContainer
{
    private static ?FlasherContainer $instance = null;

    private function __construct(private readonly ContainerInterface $container)
    {
    }

    public static function getInstance(): self
    {
        if (! self::$instance instanceof self) {
            throw new \LogicException('Container is not initialized yet. Container::init() must be called with a real container.');
        }

        return self::$instance;
    }

    public static function init(ContainerInterface $container): void
    {
        if (self::$instance instanceof self) {
            return;
        }

        self::$instance = new self($container);
    }

    public function create(string $id): FlasherInterface|NotificationFactoryInterface
    {
        $factory = $this->container->get($id);

        if (! $factory instanceof NotificationFactoryInterface && !$factory instanceof FlasherInterface) {
            throw new \InvalidArgumentException(sprintf('only instance of %s are allowed to be fetched from service container', NotificationFactoryInterface::class));
        }

        return $factory;
    }
}
