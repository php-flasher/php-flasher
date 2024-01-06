<?php

declare(strict_types=1);

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Support\Traits\ForwardsCalls;

/**
 * @mixin \Flasher\Prime\Notification\NotificationBuilderInterface
 */
class NotificationFactory implements NotificationFactoryInterface
{
    use ForwardsCalls;

    public function __construct(protected readonly StorageManagerInterface $storageManager)
    {
    }

    public function createNotificationBuilder(): NotificationBuilderInterface
    {
        return new NotificationBuilder(new Notification(), $this->storageManager);
    }

    /**
     * @param mixed[] $parameters
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->forwardCallTo($this->createNotificationBuilder(), $method, $parameters);
    }
}
