<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Container;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Tests\Prime\TestCase;

final class FlasherContainerTest extends TestCase
{
    public function testInit(): void
    {
        $this->setProperty(\Flasher\Prime\Container\FlasherContainer::class, 'instance', null);
        $container = $this->getMockBuilder(\Flasher\Prime\Container\ContainerInterface::class)->getMock();

        FlasherContainer::from($container);

        $property = $this->getProperty(\Flasher\Prime\Container\FlasherContainer::class, 'container');

        $this->assertEquals($container, $property);
    }

    public function testCreate(): void
    {
        $this->setProperty(\Flasher\Prime\Container\FlasherContainer::class, 'instance', null);

        $container = $this->getMockBuilder(\Flasher\Prime\Container\ContainerInterface::class)->getMock();
        $container
            ->method('get')
            ->willreturn($this->getMockBuilder(\Flasher\Prime\FlasherInterface::class)->getMock());

        FlasherContainer::from($container);

        $service = FlasherContainer::create('flasher');

        $this->assertInstanceOf(\Flasher\Prime\FlasherInterface::class, $service);
    }

    public function testThrowsExceptionIfNotInitialized(): void
    {
        $this->setExpectedException('\LogicException', 'Container is not initialized yet. Container::init() must be called with a real container.');

        $this->setProperty(\Flasher\Prime\Container\FlasherContainer::class, 'instance', null);

        FlasherContainer::create('flasher');
    }
}
