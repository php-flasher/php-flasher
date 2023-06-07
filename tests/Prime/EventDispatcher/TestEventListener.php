<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher;

final class TestEventListener implements \Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface
{
    public static function getSubscribedEvents(): string|array
    {
        return ['pre.foo' => 'preFoo', 'post.foo' => 'postFoo'];
    }
}
