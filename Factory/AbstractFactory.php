<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Storage\StorageManagerInterface;

abstract class AbstractFactory implements FactoryInterface
{
    /**
     * @var StorageManagerInterface
     */
    protected $storageManager;

    /**
     * @param StorageManagerInterface $storageManager
     */
    public function __construct(StorageManagerInterface $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    /**
     * {@inheritdoc}
     */
    public function createNotificationBuilder()
    {
        return new NotificationBuilder($this->getStorageManager(), new Notification(), 'default');
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->createNotificationBuilder(), $method), $parameters);
    }

    /**
     * @return StorageManagerInterface
     */
    public function getStorageManager()
    {
        return $this->storageManager;
    }
}
