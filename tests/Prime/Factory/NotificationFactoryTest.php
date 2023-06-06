<?php

namespace Flasher\Tests\Prime\Factory;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Tests\Prime\TestCase;

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

    /**
     * @return void
     */
    public function testDynamicCallToNotificationBuilder()
    {
        $storageManager = $this->getMockBuilder('Flasher\Prime\Storage\StorageManagerInterface')->getMock();
        $storageManager->expects($this->once())->method('add');

        $factory = new NotificationFactory($storageManager);
        $factory->addCreated();
    }
}
