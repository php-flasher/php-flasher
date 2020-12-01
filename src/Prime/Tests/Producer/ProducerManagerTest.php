<?php

namespace Flasher\Prime\Tests\Producer;

use Flasher\Prime\Tests\TestCase;
use ReflectionClass;

final class ProducerManagerTest extends TestCase
{
    public function testExtendToAddMoreNotifiersFactory()
    {
        $config  = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $manager = new \Notify\Notify($config);

        $producer = $this->getMockBuilder('Notify\NotifyFactory')->getMock();
        $producer->method('supports')->willReturn(true);
        $manager->addDriver($producer);

        $reflection = new ReflectionClass(get_class($manager));
        $extensions = $reflection->getProperty('drivers');
        $extensions->setAccessible(true);

        $drivers = $extensions->getValue($manager);
        $this->assertCount(1, $drivers);

        $producer1 = $manager->make('producer_1');
        $this->assertSame($producer, $producer1);
    }

    public function testNullDriver()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [] not supported.');

        $config = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $config->method('get')->willReturn(null);

        $manager = new \Notify\Notify($config);

        $producer = $this->getMockBuilder('Notify\NotifyFactory')->getMock();
        $manager->addDriver($producer);

        $this->assertSame($producer, $manager->make());
    }

    public function testNotSupportedDriver()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [not_supported] not supported.');

        $config  = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $manager = new \Notify\Notify($config);

        $producer = $this->getMockBuilder('Notify\NotifyFactory')->getMock();
        $manager->addDriver($producer);

        $this->assertSame($producer, $manager->make('not_supported'));
    }
}
