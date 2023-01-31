<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\StampsListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

class StampsListenerTest extends TestCase
{
    /**
     * @return void
     */
    public function testStampsListener()
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', array());

        $listener = new StampsListener();
        $eventDispatcher->addSubscriber($listener);

        $envelopes = array(
            new Envelope(new Notification()),
        );
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $envelopes = $event->getEnvelopes();

        $this->assertInstanceOf('Flasher\Prime\Stamp\CreatedAtStamp', $envelopes[0]->get('Flasher\Prime\Stamp\CreatedAtStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\UuidStamp', $envelopes[0]->get('Flasher\Prime\Stamp\UuidStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\DelayStamp', $envelopes[0]->get('Flasher\Prime\Stamp\DelayStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\HopsStamp', $envelopes[0]->get('Flasher\Prime\Stamp\HopsStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\PriorityStamp', $envelopes[0]->get('Flasher\Prime\Stamp\PriorityStamp'));
    }
}
