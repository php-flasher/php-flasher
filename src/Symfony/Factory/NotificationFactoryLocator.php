<?php

declare(strict_types=1);

namespace Flasher\Symfony\Factory;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Factory\NotificationFactoryLocatorInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * NotificationFactoryLocator - Locator for notification factories using Symfony's ServiceLocator.
 *
 * This class adapts Symfony's ServiceLocator to PHPFlasher's NotificationFactoryLocatorInterface,
 * enabling runtime discovery and lazy-loading of notification factories.
 *
 * Design patterns:
 * - Adapter Pattern: Adapts Symfony's ServiceLocator to PHPFlasher's interface
 * - Service Locator Pattern: Provides unified access to notification factory services
 * - Lazy Loading: Services are only instantiated when requested
 */
final readonly class NotificationFactoryLocator implements NotificationFactoryLocatorInterface
{
    /**
     * Creates a new NotificationFactoryLocator instance.
     *
     * @param ServiceLocator<NotificationFactoryInterface> $serviceLocator Symfony's service locator
     */
    public function __construct(private ServiceLocator $serviceLocator)
    {
    }

    /**
     * {@inheritdoc}
     *
     * Checks if a notification factory with the given ID exists.
     *
     * @param string $id The factory identifier
     *
     * @return bool True if the factory exists, false otherwise
     */
    public function has(string $id): bool
    {
        return $this->serviceLocator->has($id);
    }

    /**
     * {@inheritdoc}
     *
     * Gets a notification factory by ID.
     *
     * @param string $id The factory identifier
     *
     * @return NotificationFactoryInterface The notification factory
     */
    public function get(string $id): NotificationFactoryInterface
    {
        return $this->serviceLocator->get($id);
    }
}
