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

    /**
     * @throws FactoryNotFoundException
     * @throws \InvalidArgumentException
     */
    public function get(string $id): NotificationFactoryInterface
    {
        if (!$this->has($id)) {
            throw FactoryNotFoundException::create($id, array_keys($this->factories));
        }

        $factory = $this->factories[$id];

        if (\is_callable($factory)) {
            $factory = $factory();

            if (!$factory instanceof NotificationFactoryInterface) {
                throw new \InvalidArgumentException(\sprintf('Factory callable for "%s" must return an instance of %s, %s returned.', $id, NotificationFactoryInterface::class, get_debug_type($factory)));
            }
        }

        return $factory;
    }

    public function has(string $id): bool
    {
        return \array_key_exists($id, $this->factories);
    }

    public function addFactory(string $alias, callable|NotificationFactoryInterface $factory): void
    {
        $this->factories[$alias] = $factory;
    }
}
