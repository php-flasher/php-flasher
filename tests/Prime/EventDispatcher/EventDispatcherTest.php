<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Tests\Prime\TestCase;

final class EventDispatcherTest extends TestCase
{
    // Some pseudo events
    /**
     * @var string
     */
    public const preFoo = 'pre.foo';

    /**
     * @var string
     */
    public const postFoo = 'post.foo';

    /**
     * @var string
     */
    public const preBar = 'pre.bar';

    /**
     * @var string
     */
    public const postBar = 'post.bar';

    public function testInitialState(): void
    {
        $dispatcher = new EventDispatcher();
        $this->assertEquals([], $dispatcher->getListeners('fake_event'));
    }

    public function testAddListener(): void
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $dispatcher->addListener('pre.foo');
        $dispatcher->addListener('post.foo');
        $this->assertCount(1, $dispatcher->getListeners(self::preFoo));
        $this->assertCount(1, $dispatcher->getListeners(self::postFoo));
    }

    public function testDispatch(): void
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $event = new Event();
        $dispatcher->addListener(\Flasher\Tests\Prime\EventDispatcher\Event::class);
        $dispatcher->addListener('NotFoundEvent');

        $return = $dispatcher->dispatch($event);

        $this->assertTrue($listener->preFooInvoked);
        $this->assertFalse($listener->postFooInvoked);

        $this->assertInstanceOf(\Flasher\Tests\Prime\EventDispatcher\Event::class, $return);
        $this->assertEquals($event, $return);
    }

    public function testDispatchForClosure(): void
    {
        $dispatcher = new EventDispatcher();

        $invoked = 0;
        $listener = static function () use (&$invoked): void {
            ++$invoked;
        };

        $event = new Event();
        $dispatcher->addListener(\Flasher\Tests\Prime\EventDispatcher\Event::class);
        $dispatcher->addListener('AnotherEvent');
        $dispatcher->dispatch($event);
        $this->assertEquals(1, $invoked);
    }

    public function testStopEventPropagation(): void
    {
        $dispatcher = new EventDispatcher();
        $listener = new TestEventListener();

        $otherListener = new TestEventListener();

        $event = new Event();
        // postFoo() stops the propagation, so only one listener should
        // be executed
        // Manually set priority to enforce $listener to be called first
        $dispatcher->addListener(\Flasher\Tests\Prime\EventDispatcher\Event::class);
        $dispatcher->addListener(\Flasher\Tests\Prime\EventDispatcher\Event::class);
        $dispatcher->dispatch($event);
        $this->assertTrue($listener->postFooInvoked);
        $this->assertFalse($otherListener->postFooInvoked);
    }
}
