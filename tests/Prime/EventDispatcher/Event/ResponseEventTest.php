<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Tests\Prime\TestCase;

final class ResponseEventTest extends TestCase
{
    public function testResponseEvent(): void
    {
        $event = new ResponseEvent('{"foo": "bar"}', 'json');

        $this->assertEquals('{"foo": "bar"}', $event->getResponse());
        $this->assertEquals('json', $event->getPresenter());

        $event->setResponse('{"foo": "baz"}');

        $this->assertEquals('{"foo": "baz"}', $event->getResponse());
    }
}
