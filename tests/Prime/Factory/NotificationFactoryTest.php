<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Factory;

use Flasher\Prime\Factory\NotificationFactory;
use PHPUnit\Framework\TestCase;

class NotificationFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateNotificationBuilder()
    {
        $factory = new NotificationFactory();
        $builder = $factory->createNotificationBuilder();

        $this->assertInstanceOf('Flasher\Prime\Notification\NotificationBuilderInterface', $builder);
    }

    /**
     * @return void
     */
    public function testGetStorageManager()
    {
        $factory = new NotificationFactory();
        $manager = $factory->getStorageManager();

        $this->assertInstanceOf('Flasher\Prime\Storage\StorageManagerInterface', $manager);
    }
}
