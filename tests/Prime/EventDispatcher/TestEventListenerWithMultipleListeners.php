<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher;

final class TestEventListenerWithMultipleListeners implements \Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface
{
    public static function getSubscribedEvents(): string|array
    {
        return ['pre.foo' => [['preFoo1'], ['preFoo2', 10]]];
    }
}
