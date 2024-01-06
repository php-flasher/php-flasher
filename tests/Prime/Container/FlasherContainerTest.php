<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Container;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Prime\FlasherInterface;
use Flasher\Tests\Prime\TestCase;
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
        $container->method('get')->willReturn($flasher);

        FlasherContainer::from($container);

        $this->assertInstanceOf(FlasherInterface::class, FlasherContainer::create('flasher'));
    }

    public function testCreateThrowsExceptionForInvalidServiceType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected an instance of');

        $invalidService = new \stdClass();
        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->willReturn($invalidService);

        FlasherContainer::from($container);
        FlasherContainer::create('invalid_service');
    }

    public function testCreateThrowsExceptionIfNotInitialized(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('FlasherContainer has not been initialized.');

        // Ensure that FlasherContainer is not initialized
        FlasherContainer::reset();

        FlasherContainer::create('flasher');
    }
}
