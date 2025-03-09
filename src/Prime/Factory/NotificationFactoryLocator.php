<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Exception\FactoryNotFoundException;

/**
 * NotificationFactoryLocator - Registry of available factories.
 *
 * Maintains a registry of all available notification factories, allowing
 * the system to look up the appropriate factory by name at runtime.
 * Factories can be registered as instances or lazy-loaded through callbacks.
 *
 * Design pattern: Service Locator - Centralizes factory discovery and
 * instantiation, enabling loose coupling between components.
 */
final class NotificationFactoryLocator implements NotificationFactoryLocatorInterface
{
    /**
     * Map of factory aliases to instances or factory callbacks.
     *
     * @var array<string, callable|NotificationFactoryInterface>
     */
    private array $factories = [];

    /**
     * Gets a notification factory by its identifier.
     *
     * If the factory was registered as a callback, it will be invoked to create
     * the actual factory instance on first access.
     *
     * @param string $id The identifier for the factory to retrieve
     *
     * @return NotificationFactoryInterface The requested notification factory
     *
     * @throws FactoryNotFoundException If no factory is registered with the given identifier
     */
    public function get(string $id): NotificationFactoryInterface
    {
        if (!$this->has($id)) {
            throw FactoryNotFoundException::create($id, array_keys($this->factories));
        }

        $factory = $this->factories[$id];

        return \is_callable($factory) ? $factory() : $factory;
    }

    /**
     * Checks if a notification factory exists for the given identifier.
     *
     * @param string $id The identifier to check
     *
     * @return bool True if a factory exists for the given identifier, false otherwise
     */
    public function has(string $id): bool
    {
        return \array_key_exists($id, $this->factories);
    }

    /**
     * Register a custom notification factory.
     *
     * This method allows registering either a factory instance directly or a callback
     * that creates the factory when needed (lazy-loading).
     *
     * Example:
     * ```php
     * // Register a factory instance
     * $locator->addFactory('custom', new CustomFactory($storageManager));
     *
     * // Register a factory with lazy-loading
     * $locator->addFactory('custom', function() use ($storageManager) {
     *     return new ExpensiveFactory($storageManager);
     * });
     * ```
     *
     * @param string                                $alias   The identifier for the factory
     * @param callable|NotificationFactoryInterface $factory The factory instance or a callback that returns one
     */
    public function addFactory(string $alias, callable|NotificationFactoryInterface $factory): void
    {
        $this->factories[$alias] = $factory;
    }
}
