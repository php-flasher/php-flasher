<?php

namespace Flasher\Tests\Prime\Container;

use Flasher\Prime\Container\FlasherContainer;
use Flasher\Tests\Prime\TestCase;

class FlasherContainerTest extends TestCase
{
    /**
     * @return void
     */
    public function testInit()
    {
        $this->setProperty('Flasher\Prime\Container\FlasherContainer', 'instance', null);
        $container = $this->getMockBuilder('Flasher\Prime\Container\ContainerInterface')->getMock();

        FlasherContainer::init($container);

        $property = $this->getProperty('Flasher\Prime\Container\FlasherContainer', 'container');

        $this->assertEquals($container, $property);
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $this->setProperty('Flasher\Prime\Container\FlasherContainer', 'instance', null);

        $container = $this->getMockBuilder('Flasher\Prime\Container\ContainerInterface')->getMock();
        $container
            ->method('get')
            ->willreturn($this->getMockBuilder('Flasher\Prime\FlasherInterface')->getMock());

        FlasherContainer::init($container);

        $service = FlasherContainer::create('flasher');

        $this->assertInstanceOf('Flasher\Prime\FlasherInterface', $service);
    }

    /**
     * @return void
     */
    public function testThrowsExceptionIfNotInitialized()
    {
        $this->setExpectedException('\LogicException', 'Container is not initialized yet. Container::init() must be called with a real container.');

        $this->setProperty('Flasher\Prime\Container\FlasherContainer', 'instance', null);

        FlasherContainer::create('flasher');
    }
}
