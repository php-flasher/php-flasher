<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

final class TestEventListener implements EventListenerInterface
{
    public static function getSubscribedEvents(): string|array
    {
        return ['pre.foo' => 'preFoo', 'post.foo' => 'postFoo'];
    }
}
