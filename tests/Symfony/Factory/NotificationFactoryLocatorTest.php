<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Factory;

use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Symfony\Factory\NotificationFactoryLocator;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class NotificationFactoryLocatorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var MockInterface&ServiceLocator<NotificationFactoryInterface> */
    private MockInterface&ServiceLocator $serviceLocatorMock;
    private NotificationFactoryLocator $notificationFactoryLocator;

    protected function setUp(): void
    {
        $this->serviceLocatorMock = \Mockery::mock(ServiceLocator::class);
        $this->notificationFactoryLocator = new NotificationFactoryLocator($this->serviceLocatorMock);
    }

    public function testHasReturnsFalseWhenServiceDoesNotExist(): void
    {
        $this->serviceLocatorMock->expects()
            ->has('non_existing_service')
            ->andReturns(false);

        $this->assertFalse($this->notificationFactoryLocator->has('non_existing_service'));
    }

    public function testHasReturnsTrueWhenServiceExists(): void
    {
        $this->serviceLocatorMock
            ->expects()
            ->has('existing_service')
            ->andReturns(true);

        $this->assertTrue($this->notificationFactoryLocator->has('existing_service'));
    }

    public function testGetShouldReturnExistingNotificationFactoryInterface(): void
    {
        $notificationFactory = \Mockery::mock(NotificationFactoryInterface::class);

        $this->serviceLocatorMock
            ->expects()
            ->get('existing_service')
            ->andReturns($notificationFactory);

        $actual = $this->notificationFactoryLocator->get('existing_service');

        $this->assertSame($notificationFactory, $actual);
    }

    public function testGetThrowsWhenServiceDoesNotExist(): void
    {
        $this->serviceLocatorMock
            ->expects()
            ->get('non_existing_service')
            ->andThrow(new ServiceNotFoundException('non_existing_service'));

        $this->expectException(ServiceNotFoundException::class);
        $this->expectExceptionMessage('non_existing_service');

        $this->notificationFactoryLocator->get('non_existing_service');
    }
}
