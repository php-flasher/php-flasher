<?php

namespace Flasher\Prime\Tests\EventDispatcher;

use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\Tests\TestCase;
use Symfony\Component\EventDispatcher\Event;

class EventDispatcherTest extends TestCase
{
    public function testInitialState()
    {
        $dispatcher = new EventDispatcher();
        $this->assertSame(array(), $dispatcher->getListeners('fake_event'));
    }

    public function testAddListener()
    {
        $listener = $this->getMockBuilder('Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface')->getMock();

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('mocked_event', array($listener, '__invoke'));

        $this->assertSame(array(array($listener, '__invoke')), $dispatcher->getListeners('mocked_event'));
    }

    public function testGetListenersSortsByPriority()
    {
        $listener1 = $this->getMockBuilder('Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface')->getMock();
        $listener2 = $this->getMockBuilder('Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface')->getMock();
        $listener3 = $this->getMockBuilder('Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface')->getMock();

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('mocked_event', array($listener1, '__invoke'), -10);
        $dispatcher->addListener('mocked_event', array($listener2, '__invoke'), 10);
        $dispatcher->addListener('mocked_event', array($listener3, '__invoke'));

        $expected = array(
            array($listener2, '__invoke'),
            array($listener3, '__invoke'),
            array($listener1, '__invoke'),
        );

        $this->assertSame($expected, $dispatcher->getListeners('mocked_event'));
    }

    public function testDispatch()
    {
        return;
        $this->dispatcher->addListener('pre.foo', array($this->listener, 'preFoo'));
        $this->dispatcher->addListener('post.foo', array($this->listener, 'postFoo'));
        $this->dispatcher->dispatch(self::preFoo);
        $this->assertTrue($this->listener->preFooInvoked);
        $this->assertFalse($this->listener->postFooInvoked);
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\Event', $this->dispatcher->dispatch('noevent'));
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\Event', $this->dispatcher->dispatch(self::preFoo));
        $event = new Event();
        $return = $this->dispatcher->dispatch(self::preFoo, $event);
        $this->assertEquals('pre.foo', $event->getName());
        $this->assertSame($event, $return);
    }
}
