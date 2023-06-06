<?php

namespace Flasher\Tests\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;
use Flasher\Tests\Prime\TestCase;

class EventDispatcherTest extends TestCase
{
    // Some pseudo events
    public const preFoo = 'pre.foo';

    public const postFoo = 'post.foo';

    public const preBar = 'pre.bar';

    public const postBar = 'post.bar';

    /**
     * @return void
     */
    public function testInitialState()
    {
        $dispatcher = new EventDispatcher();
        $this->assertEquals([], $dispatcher->getListeners('fake_event'));
    }

    /**
     * @return void
     */
    public function testAddListener()
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $dispatcher->addListener('pre.foo', [$listener, 'preFoo']);
        $dispatcher->addListener('post.foo', [$listener, 'postFoo']);
        $this->assertCount(1, $dispatcher->getListeners(self::preFoo));
        $this->assertCount(1, $dispatcher->getListeners(self::postFoo));
    }

    /**
     * @return void
     */
    public function testDispatch()
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $event = new Event();
        $dispatcher->addListener('Flasher\Tests\Prime\EventDispatcher\Event', [$listener, 'preFoo']);
        $dispatcher->addListener('NotFoundEvent', [$listener, 'postFoo']);

        $return = $dispatcher->dispatch($event);

        $this->assertTrue($listener->preFooInvoked);
        $this->assertFalse($listener->postFooInvoked);

        $this->assertInstanceOf('Flasher\Tests\Prime\EventDispatcher\Event', $return);
        $this->assertEquals($event, $return);
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function testStopEventPropagation()
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $otherListener = new TestEventListener();

        $event = new Event();
        // postFoo() stops the propagation, so only one listener should
        // be executed
        // Manually set priority to enforce $listener to be called first
        $dispatcher->addListener('Flasher\Tests\Prime\EventDispatcher\Event', [$listener, 'postFoo'], 10);
        $dispatcher->addListener('Flasher\Tests\Prime\EventDispatcher\Event', [$otherListener, 'preFoo']);
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
        return [
            'pre.foo' => 'preFoo',
            'post.foo' => 'postFoo',
        ];
    }
}

class TestEventSubscriberWithPriorities implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pre.foo' => ['preFoo', 10],
            'post.foo' => ['postFoo'],
        ];
    }
}

class TestEventSubscriberWithMultipleListeners implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pre.foo' => [
                ['preFoo1'],
                ['preFoo2', 10],
            ],
        ];
    }
}
