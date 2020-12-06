<?php

namespace Flasher\Prime\Tests\Manager;

use Flasher\Prime\Flasher;
use Flasher\Prime\Tests\TestCase;

final class ManagerTest extends TestCase
{
    public function testDefaultDriver()
    {
        $config = $this->getMockBuilder('Flasher\Prime\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new Flasher($config);
        $this->assertEquals('default_notifier', $manager->getDefaultDriver());
    }

    public function testMakeDriver()
    {
        $config = $this->getMockBuilder('Flasher\Prime\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new Flasher($config);

        $producer = $this->getMockBuilder('Flasher\Prime\Factory\FlasherFactoryInterface')->getMock();
        $producer->method('supports')->willReturn(true);
        $manager->addDriver($producer);

        $this->assertSame($producer, $manager->make('fake'));
    }

    public function testDriverNotSupported()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [test_driver] not supported.');

        $config = $this->getMockBuilder('Flasher\Prime\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new Flasher($config);

        $producer = $this->getMockBuilder('Flasher\Prime\Factory\FlasherFactoryInterface')->getMock();
        $manager->addDriver($producer);

        $manager->make('test_driver');
    }
}
