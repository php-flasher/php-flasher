<?php

namespace Flasher\Prime\Tests\EventDispatcher;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;
use Flasher\Prime\Tests\TestCase;

class EventDispatcherTest extends TestCase
{
    /* Some pseudo events */
    const preFoo  = 'pre.foo';
    const postFoo = 'post.foo';
    const preBar  = 'pre.bar';
    const postBar = 'post.bar';

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var TestEventListener
     */
    private $listener;

    protected function setUp()
    {
        $this->dispatcher = new EventDispatcher();
        $this->listener = new TestEventListener();
    }

    protected function tearDown()
    {
        $this->dispatcher = null;
        $this->listener = null;
    }

    public function testInitialState()
    {
        $this->assertSame(array(), $this->dispatcher->getListeners('fake_event'));
    }

    public function testAddListener()
    {
        $this->dispatcher->addListener('pre.foo', array($this->listener, 'preFoo'));
        $this->dispatcher->addListener('post.foo', array($this->listener, 'postFoo'));
        $this->assertCount(1, $this->dispatcher->getListeners(self::preFoo));
        $this->assertCount(1, $this->dispatcher->getListeners(self::postFoo));
    }

    public function testGetListenersSortsByPriority()
    {
        $listener1 = new TestEventListener();
        $listener2 = new TestEventListener();
        $listener3 = new TestEventListener();
        $listener1->name = '1';
        $listener2->name = '2';
        $listener3->name = '3';

        $this->dispatcher->addListener('pre.foo', array($listener1, 'preFoo'), -10);
        $this->dispatcher->addListener('pre.foo', array($listener2, 'preFoo'), 10);
        $this->dispatcher->addListener('pre.foo', array($listener3, 'preFoo'));

        $expected = array(
            array($listener2, 'preFoo'),
            array($listener3, 'preFoo'),
            array($listener1, 'preFoo'),
        );

        $this->assertSame($expected, $this->dispatcher->getListeners('pre.foo'));
    }

    public function testDispatch()
    {
        $event = new Event();
        $this->dispatcher->addListener('Flasher\Prime\Tests\EventDispatcher\Event', array($this->listener, 'preFoo'));
        $this->dispatcher->addListener('NotFoundEvent', array($this->listener, 'postFoo'));

        $return = $this->dispatcher->dispatch($event);

        $this->assertTrue($this->listener->preFooInvoked);
        $this->assertFalse($this->listener->postFooInvoked);

        $this->assertInstanceOf('Flasher\Prime\Tests\EventDispatcher\Event', $return);
        $this->assertSame($event, $return);
    }

    public function testDispatchForClosure()
    {
        $invoked = 0;
        $listener = function () use (&$invoked) {
            ++$invoked;
        };

        $event = new Event();
        $this->dispatcher->addListener('Flasher\Prime\Tests\EventDispatcher\Event', $listener);
        $this->dispatcher->addListener('AnotherEvent', $listener);
        $this->dispatcher->dispatch($event);
        $this->assertEquals(1, $invoked);
    }

    public function testStopEventPropagation()
    {
        $otherListener = new TestEventListener();

        $event = new Event();
        // postFoo() stops the propagation, so only one listener should
        // be executed
        // Manually set priority to enforce $this->listener to be called first
        $this->dispatcher->addListener('Flasher\Prime\Tests\EventDispatcher\Event', array($this->listener, 'postFoo'), 10);
        $this->dispatcher->addListener('Flasher\Prime\Tests\EventDispatcher\Event', array($otherListener, 'preFoo'));
        $this->dispatcher->dispatch($event);
        $this->assertTrue($this->listener->postFooInvoked);
        $this->assertFalse($otherListener->postFooInvoked);
    }

    public function testDispatchByPriority()
    {
        $event = new Event();

        $invoked = array();
        $listener1 = function () use (&$invoked) {
            $invoked[] = '1';
        };
        $listener2 = function () use (&$invoked) {
            $invoked[] = '2';
        };
        $listener3 = function () use (&$invoked) {
            $invoked[] = '3';
        };
        $this->dispatcher->addListener('Flasher\Prime\Tests\EventDispatcher\Event', $listener1, -10);
        $this->dispatcher->addListener('Flasher\Prime\Tests\EventDispatcher\Event', $listener2);
        $this->dispatcher->addListener('Flasher\Prime\Tests\EventDispatcher\Event', $listener3, 10);
        $this->dispatcher->dispatch($event);
        $this->assertEquals(array('3', '2', '1'), $invoked);
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
        return array('pre.foo' => 'preFoo', 'post.foo' => 'postFoo');
    }
}

class TestEventSubscriberWithPriorities implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'pre.foo'  => array('preFoo', 10),
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
