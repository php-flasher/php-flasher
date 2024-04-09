<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\PostRemoveEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use PHPUnit\Framework\TestCase;

final class PostRemoveEventTest extends TestCase
{
    public function testPostRemoveEvent(): void
    {
        $envelopesToRemove = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $envelopesToKeep = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $event = new PostRemoveEvent($envelopesToRemove, $envelopesToKeep);

        $this->assertEquals($envelopesToRemove, $event->getEnvelopesToRemove());
        $this->assertEquals($envelopesToKeep, $event->getEnvelopesToKeep());
    }
}
