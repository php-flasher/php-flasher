<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

interface NotificationFactoryLocatorInterface
{
    public function has(string $id): bool;

    public function get(string $id): NotificationFactoryInterface;
}
