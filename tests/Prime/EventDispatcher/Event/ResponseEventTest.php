<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use PHPUnit\Framework\TestCase;

final class ResponseEventTest extends TestCase
{
    public function testResponseEvent(): void
    {
        $event = new ResponseEvent('{"foo": "bar"}', 'json');

        $this->assertSame('{"foo": "bar"}', $event->getResponse());
        $this->assertSame('json', $event->getPresenter());

        $event->setResponse('{"foo": "baz"}');

        $this->assertSame('{"foo": "baz"}', $event->getResponse());
    }
}
