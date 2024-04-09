<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Factory;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Storage\StorageManagerInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class NotificationFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCreateNotificationBuilder(): void
    {
        $storageManager = \Mockery::mock(StorageManagerInterface::class);
        $factory = new NotificationFactory($storageManager);

        $builder = $factory->createNotificationBuilder();

        $this->assertInstanceOf(NotificationBuilderInterface::class, $builder);
    }

    public function testStorageManagerForwardsAnyMethodCall(): void
    {
        $method = 'test_method';
        $arguments = ['test_argument'];

        $mockedInterface = \Mockery::mock(NotificationBuilderInterface::class);
        $mockedInterface->allows($method)
            ->withArgs($arguments)
            ->andReturnTrue();

        $storageManager = \Mockery::mock(StorageManagerInterface::class);
        $factory = \Mockery::mock(NotificationFactory::class, [$storageManager]) // @phpstan-ignore-line
            ->makePartial()
            ->allows('createNotificationBuilder')
            ->andReturns($mockedInterface)
            ->getMock();

        $result = $factory->__call($method, $arguments); // @phpstan-ignore-line

        $this->assertTrue($result);
    }
}
