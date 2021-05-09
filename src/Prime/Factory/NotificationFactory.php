<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Storage\StorageManagerInterface;

class NotificationFactory implements NotificationFactoryInterface
{
    /**
     * @var StorageManagerInterface
     */
    protected $storageManager;

    public function __construct(StorageManagerInterface $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->createNotificationBuilder(), $method), $parameters);
    }

    public function createNotificationBuilder()
    {
        return new NotificationBuilder($this->getStorageManager(), new Notification(), 'template');
    }

    /**
     * @return StorageManagerInterface
     */
    public function getStorageManager()
    {
        return $this->storageManager;
    }
}
