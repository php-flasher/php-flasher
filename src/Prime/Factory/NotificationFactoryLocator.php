<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Exception\FactoryNotFoundException;

final class NotificationFactoryLocator implements NotificationFactoryLocatorInterface
{
    /**
     * @var array<string, callable|NotificationFactoryInterface>
     */
    private array $factories = [];

    public function get(string $id): NotificationFactoryInterface
    {
        if (!$this->has($id)) {
            throw FactoryNotFoundException::create($id, array_keys($this->factories));
        }

        $factory = $this->factories[$id];

        return \is_callable($factory) ? $factory() : $factory;
    }

    public function has(string $id): bool
    {
        return \array_key_exists($id, $this->factories);
    }

    /**
     * Register a custom notification factory.
     */
    public function addFactory(string $alias, callable|NotificationFactoryInterface $factory): void
    {
        $this->factories[$alias] = $factory;
    }
}
