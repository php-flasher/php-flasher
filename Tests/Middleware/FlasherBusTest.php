<?php

namespace Flasher\Prime\Tests\Middleware;

use Flasher\Prime\Config\Config;
use Flasher\Prime\Envelope;
use Flasher\Prime\Middleware\AddCreatedAtStampMiddleware;
use Flasher\Prime\Middleware\AddPriorityStampMiddleware;
use Flasher\Prime\Middleware\FlasherBus;
use Flasher\Prime\Stamp\PriorityStamp;
use PHPUnit\Framework\TestCase;

final class FlasherBusTest extends TestCase
{
    public function testHandle()
    {
        $flasherBus = new FlasherBus();
        $flasherBus->addMiddleware(new AddPriorityStampMiddleware());
        $flasherBus->addMiddleware(new AddCreatedAtStampMiddleware());

        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $envelope     = new Envelope($notification);

        $flasherBus->dispatch($envelope);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertCount(2, $envelope->all());

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertEquals(0, $priorityStamp->getPriority());

        $createdAtStamp = $envelope->get('Flasher\Prime\Stamp\CreatedAtStamp');
        $this->assertInstanceOf('DateTime', $createdAtStamp->getCreatedAt());
    }

    public function testHandleWithExistingStamps()
    {
        $flasherBus = new FlasherBus();
        $flasherBus->addMiddleware(new AddPriorityStampMiddleware());
        $flasherBus->addMiddleware(new AddCreatedAtStampMiddleware());

        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamps = array(
            new PriorityStamp(1),
        );
        $envelope = new Envelope($notification, $stamps);

        $flasherBus->dispatch($envelope);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertCount(2, $envelope->all());

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertInstanceOf('Flasher\Prime\Stamp\PriorityStamp', $priorityStamp);
        $this->assertEquals(1, $priorityStamp->getPriority());
    }
}
