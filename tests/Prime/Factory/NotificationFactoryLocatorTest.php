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

    public function testGetWithCallableFactory(): void
    {
        $factoryMock = \Mockery::mock(NotificationFactoryInterface::class);
        $notificationFactoryLocator = new NotificationFactoryLocator();
        $notificationFactoryLocator->addFactory('alias', fn () => $factoryMock);

        $retrievedFactory = $notificationFactoryLocator->get('alias');

        $this->assertSame($factoryMock, $retrievedFactory);
    }

    public function testGetWithCallableFactoryCalledEachTime(): void
    {
        $callCount = 0;
        $notificationFactoryLocator = new NotificationFactoryLocator();
        $notificationFactoryLocator->addFactory('alias', function () use (&$callCount) {
            ++$callCount;

            return \Mockery::mock(NotificationFactoryInterface::class);
        });

        $notificationFactoryLocator->get('alias');
        $notificationFactoryLocator->get('alias');

        $this->assertSame(2, $callCount);
    }

    public function testGetWithCallableReturningInvalidTypeThrowsException(): void
    {
        $notificationFactoryLocator = new NotificationFactoryLocator();
        $notificationFactoryLocator->addFactory('invalid', fn () => 'not a factory');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Factory callable for "invalid" must return an instance of');

        $notificationFactoryLocator->get('invalid');
    }

    public function testGetWithCallableReturningNullThrowsException(): void
    {
        $notificationFactoryLocator = new NotificationFactoryLocator();
        $notificationFactoryLocator->addFactory('null_factory', fn () => null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Factory callable for "null_factory" must return an instance of');

        $notificationFactoryLocator->get('null_factory');
    }

    public function testAddFactoryOverwritesExistingFactory(): void
    {
        $factory1 = \Mockery::mock(NotificationFactoryInterface::class);
        $factory2 = \Mockery::mock(NotificationFactoryInterface::class);

        $notificationFactoryLocator = new NotificationFactoryLocator();
        $notificationFactoryLocator->addFactory('alias', $factory1);
        $notificationFactoryLocator->addFactory('alias', $factory2);

        $this->assertSame($factory2, $notificationFactoryLocator->get('alias'));
    }
}
