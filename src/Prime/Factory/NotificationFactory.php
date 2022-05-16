<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Prime\Storage\StorageManagerInterface;

class NotificationFactory implements NotificationFactoryInterface
{
    /**
     * @var StorageManagerInterface
     */
    protected $storageManager;

    /**
     * @var string|null
     */
    protected $handler;

    /**
     * @param string|null $handler
     */
    public function __construct(StorageManagerInterface $storageManager = null, $handler = null)
    {
        $this->storageManager = $storageManager ?: new StorageManager();
        $this->handler = $handler;
    }

    /**
     * @param string  $method
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        /** @var callable $callback */
        $callback = array($this->createNotificationBuilder(), $method);

        return \call_user_func_array($callback, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function createNotificationBuilder()
    {
        return new NotificationBuilder($this->getStorageManager(), new Notification(), $this->handler);
    }

    /**
     * @return StorageManagerInterface
     */
    public function getStorageManager()
    {
        return $this->storageManager;
    }
}
