<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Factory;

use Flasher\Prime\Exception\FactoryNotFoundException;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\Factory\NotificationFactoryLocator;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class NotificationFactoryLocatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testGetWithRegisteredFactory(): void
    {
        $factoryMock = \Mockery::mock(NotificationFactoryInterface::class);
        $notificationFactoryLocator = new NotificationFactoryLocator();
        $notificationFactoryLocator->addFactory('alias', $factoryMock);

        $retrievedFactory = $notificationFactoryLocator->get('alias');

        $this->assertSame($factoryMock, $retrievedFactory);
    }

    public function testGetWithUnregisteredFactory(): void
    {
        $notificationFactoryLocator = new NotificationFactoryLocator();

        $this->expectException(FactoryNotFoundException::class);
        $notificationFactoryLocator->get('alias');
    }

    public function testHas(): void
    {
        $factoryMock = \Mockery::mock(NotificationFactoryInterface::class);
        $notificationFactoryLocator = new NotificationFactoryLocator();

        $this->assertFalse($notificationFactoryLocator->has('alias'));

        $notificationFactoryLocator->addFactory('alias', $factoryMock);

        $this->assertTrue($notificationFactoryLocator->has('alias'));
    }

    public function testAddFactory(): void
    {
        $factoryMock = \Mockery::mock(NotificationFactoryInterface::class);
        $notificationFactoryLocator = new NotificationFactoryLocator();
        $notificationFactoryLocator->addFactory('alias', $factoryMock);

        $this->assertTrue($notificationFactoryLocator->has('alias'));
    }
}
