<?php

namespace Flasher\Prime\Tests\Manager;

use NotifyFlasher\Prime;
use Flasher\Prime\Tests\TestCase;

final class ManagerTest extends TestCase
{
    public function testDefaultDriver()
    {
        $config = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new Notify($config);
        $this->assertEquals('default_notifier', $manager->getDefaultDriver());
    }

    public function testMakeDriver()
    {
        $config = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new Notify($config);

        $producer = $this->getMockBuilder('NotifyFlasher\PrimeFactory')->getMock();
        $producer->method('supports')->willReturn(true);
        $manager->addDriver($producer);

        $this->assertSame($producer, $manager->make('fake'));
    }

    public function testDriverNotSupported()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [test_driver] not supported.');

        $config = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')
            ->with('default')
            ->willReturn('default_notifier');

        $manager = new Notify($config);

        $producer = $this->getMockBuilder('NotifyFlasher\PrimeFactory')->getMock();
        $manager->addDriver($producer);

        $manager->make('test_driver');
    }
}
