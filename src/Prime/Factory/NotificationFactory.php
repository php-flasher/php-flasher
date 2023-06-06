<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Prime\Storage\StorageManagerInterface;

class NotificationFactory implements NotificationFactoryInterface
{
    protected StorageManagerInterface $storageManager;

    public function __construct(
        protected string $handler = 'flasher',
        StorageManagerInterface $storageManager = null,
    ) {
        $this->storageManager = $storageManager ?: new StorageManager();
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
        /** @var callable $callback */
        $callback = [$this->createNotificationBuilder(), $method];

        return $callback(...$parameters);
    }
}
