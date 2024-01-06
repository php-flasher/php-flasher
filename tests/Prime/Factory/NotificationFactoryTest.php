<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Factory;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Tests\Prime\TestCase;

final class NotificationFactoryTest extends TestCase
{
    public function testCreateNotificationBuilder(): void
    {
        $storageManager = $this->createMock(StorageManagerInterface::class);
        $factory = new NotificationFactory($storageManager);
        $builder = $factory->createNotificationBuilder();

        $this->assertInstanceOf(NotificationBuilderInterface::class, $builder);
    }

    public function testGetStorageManager(): void
    {
        $storageManager = $this->createMock(StorageManagerInterface::class);
        $factory = new NotificationFactory($storageManager);

        $this->assertInstanceOf(StorageManagerInterface::class, $this->getProperty($factory, 'storageManager'));
    }

    public function testDynamicCallToNotificationBuilder(): void
    {
        $storageManager = $this->getMockBuilder(StorageManagerInterface::class)->getMock();
        $storageManager->expects($this->once())->method('add');

        $factory = new NotificationFactory($storageManager);
        $factory->addCreated();
    }
}
