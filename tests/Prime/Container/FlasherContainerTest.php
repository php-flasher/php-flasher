<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Container;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\Factory\NotificationFactoryInterface;
use Flasher\Prime\FlasherInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class FlasherContainerTest extends TestCase
{
    protected function setUp(): void
    {
        // Reset the FlasherContainer instance to ensure isolation between tests
        FlasherContainer::reset();
    }

    public function testCreateReturnsCorrectType(): void
    {
        $flasher = $this->createMock(FlasherInterface::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')->willReturn(true);
        $container->method('get')->willReturn($flasher);

        FlasherContainer::from($container);

        $this->assertInstanceOf(FlasherInterface::class, FlasherContainer::create('flasher'));
    }

    public function testCreateThrowsExceptionForNotFoundService(): void
    {
        $invalidService = new \stdClass();
        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')->willReturn(false);
        $container->method('get')->willReturn($invalidService);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The container does not have the requested service "invalid_service".');

        FlasherContainer::from($container);
        FlasherContainer::create('invalid_service');
    }

    public function testCreateThrowsExceptionForInvalidServiceType(): void
    {
        $invalidService = new \stdClass();
        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')->willReturn(true);
        $container->method('get')->willReturn($invalidService);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Expected an instance of "%s" or "%s", got "%s".', FlasherInterface::class, NotificationFactoryInterface::class, get_debug_type($invalidService)));

        FlasherContainer::from($container);
        FlasherContainer::create('invalid_service');
    }

    public function testCreateThrowsExceptionIfNotInitialized(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('FlasherContainer has not been initialized. Please initialize it by calling FlasherContainer::from(ContainerInterface $container).');

        // Ensure that FlasherContainer is not initialized
        FlasherContainer::reset();

        FlasherContainer::create('flasher');
    }
}
