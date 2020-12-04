<?php

namespace Flasher\Prime\Tests\Producer;

use Flasher\Prime\EventDispatcher\Event\BeforeFilter;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\FlusherEvents;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Tests\TestCase;
use ReflectionClass;

final class ProducerManagerTest extends TestCase
{
    public function testExtendToAddMoreNotifiersFactory()
    {
        $config  = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $manager = new Flasher\PrimeFlasher\Prime($config);

        $producer = $this->getMockBuilder('NotifyFlasher\PrimeFactory')->getMock();
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

        $manager = new \Flasher\PrimeFlasher\Prime($config);

        $producer = $this->getMockBuilder('NotifyFlasher\PrimeFactory')->getMock();
        $manager->addDriver($producer);

        $this->assertSame($producer, $manager->make());
    }

    public function testNotSupportedDriver()
    {
        $this->setExpectedException('InvalidArgumentException', 'Driver [not_supported] not supported.');

        $config  = $this->getMockBuilder('Notify\Config\ConfigInterface')->getMock();
        $manager = new Flasher\PrimeFlasher\Prime($config);

        $producer = $this->getMockBuilder('NotifyFlasher\PrimeFactory')->getMock();
        $manager->addDriver($producer);

        $this->assertSame($producer, $manager->make('not_supported'));
    }

    public function testDispatcher()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(FlusherEvents::NOTIFICATION_CLEARED, function ($event) {

            return $event;
        });

        $dispatcher->dispatch(new Notification());
    }
}
