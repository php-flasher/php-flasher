<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Factory;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Tests\Prime\TestCase;

final class NotificationFactoryTest extends TestCase
{
    public function testCreateNotificationBuilder(): void
    {
        $factory = new NotificationFactory();
        $builder = $factory->createNotificationBuilder();

        $this->assertInstanceOf(\Flasher\Prime\Notification\NotificationBuilderInterface::class, $builder);
    }

    public function testGetStorageManager(): void
    {
        $factory = new NotificationFactory();
        $manager = $factory->getStorageManager();

        $this->assertInstanceOf(\Flasher\Prime\Storage\StorageManagerInterface::class, $manager);
    }

    public function testDynamicCallToNotificationBuilder(): void
    {
        $storageManager = $this->getMockBuilder(\Flasher\Prime\Storage\StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $factory = new NotificationFactory($storageManager);
        $factory->addCreated();
    }
}
