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

        $dispatcher->addListener($listener);

        $this->assertCount(1, $dispatcher->getListeners('preFoo'));
        $this->assertCount(1, $dispatcher->getListeners('postFoo'));
    }
}
