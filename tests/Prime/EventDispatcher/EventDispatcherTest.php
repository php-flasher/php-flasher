<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;
use Flasher\Tests\Prime\TestCase;

class EventDispatcherTest extends TestCase
{
    // Some pseudo events
    const preFoo = 'pre.foo';

    const postFoo = 'post.foo';

    const preBar = 'pre.bar';

    const postBar = 'post.bar';

    public function testInitialState()
    {
        $dispatcher = new EventDispatcher();
        $this->assertEquals(array(), $dispatcher->getListeners('fake_event'));
    }

    public function testAddListener()
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $dispatcher->addListener('pre.foo', array($listener, 'preFoo'));
        $dispatcher->addListener('post.foo', array($listener, 'postFoo'));
        $this->assertCount(1, $dispatcher->getListeners(self::preFoo));
        $this->assertCount(1, $dispatcher->getListeners(self::postFoo));
    }

    public function testDispatch()
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $event = new Event();
        $dispatcher->addListener('Flasher\Tests\Prime\EventDispatcher\Event', array($listener, 'preFoo'));
        $dispatcher->addListener('NotFoundEvent', array($listener, 'postFoo'));

        $return = $dispatcher->dispatch($event);

        $this->assertTrue($listener->preFooInvoked);
        $this->assertFalse($listener->postFooInvoked);

        $this->assertInstanceOf('Flasher\Tests\Prime\EventDispatcher\Event', $return);
        $this->assertEquals($event, $return);
    }

    public function testDispatchForClosure()
    {
        $dispatcher = new EventDispatcher();

        $invoked = 0;
        $listener = function () use (&$invoked) {
            ++$invoked;
        };

        $event = new Event();
        $dispatcher->addListener('Flasher\Tests\Prime\EventDispatcher\Event', $listener);
        $dispatcher->addListener('AnotherEvent', $listener);
        $dispatcher->dispatch($event);
        $this->assertEquals(1, $invoked);
    }

    public function testStopEventPropagation()
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $otherListener = new TestEventListener();

        $event = new Event();
        // postFoo() stops the propagation, so only one listener should
        // be executed
        // Manually set priority to enforce $listener to be called first
        $dispatcher->addListener('Flasher\Tests\Prime\EventDispatcher\Event', array($listener, 'postFoo'), 10);
        $dispatcher->addListener('Flasher\Tests\Prime\EventDispatcher\Event', array($otherListener, 'preFoo'));
        $dispatcher->dispatch($event);
        $this->assertTrue($listener->postFooInvoked);
        $this->assertFalse($otherListener->postFooInvoked);
    }
}

class Event implements StoppableEventInterface
{
    private $propagationStopped = false;

    private $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    public function stopPropagation()
    {
        $this->propagationStopped = true;
    }
}

class CallableClass
{
    public function __invoke()
    {
    }
}

class TestEventListener
{
    public $preFooInvoked = false;

    public $postFooInvoked = false;

    public function preFoo(Event $e)
    {
        $this->preFooInvoked = true;
    }

    public function postFoo(Event $e)
    {
        $this->postFooInvoked = true;

        $e->stopPropagation();
    }
}

class TestEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'pre.foo' => 'preFoo',
            'post.foo' => 'postFoo',
        );
    }
}

class TestEventSubscriberWithPriorities implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'pre.foo' => array('preFoo', 10),
            'post.foo' => array('postFoo'),
        );
    }
}

class TestEventSubscriberWithMultipleListeners implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'pre.foo' => array(
                array('preFoo1'),
                array('preFoo2', 10),
            ),
        );
    }
}
