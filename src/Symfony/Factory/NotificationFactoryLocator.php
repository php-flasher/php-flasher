<?php

declare(strict_types=1);

namespace Flasher\Symfony\Factory;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Factory\NotificationFactoryLocatorInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

final readonly class NotificationFactoryLocator implements NotificationFactoryLocatorInterface
{
    /**
     * @param ServiceLocator<NotificationFactoryInterface> $serviceLocator
     */
    public function __construct(private ServiceLocator $serviceLocator)
    {
    }

    public function has(string $id): bool
    {
        return $this->serviceLocator->has($id);
    }

    public function get(string $id): NotificationFactoryInterface
    {
        return $this->serviceLocator->get($id);
    }
}
