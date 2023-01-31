<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\RemoveListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Tests\Prime\TestCase;

class RemoveListenerTest extends TestCase
{
    /**
     * @return void
     */
    public function testRemoveListener()
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', array());

        $listener = new RemoveListener();
        $eventDispatcher->addSubscriber($listener);

        $envelopes = array(
           new Envelope(new Notification()),
           new Envelope(new Notification(), new HopsStamp(2)),
           new Envelope(new Notification(), new HopsStamp(1)),
           new Envelope(new Notification(), new HopsStamp(3)),
        );
        $event = new RemoveEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $this->assertEquals(array($envelopes[0], $envelopes[2]), $event->getEnvelopesToRemove());
        $this->assertEquals(array($envelopes[1], $envelopes[3]), $event->getEnvelopesToKeep());
    }
}
