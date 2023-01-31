<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\AddToStorageListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;
use Flasher\Tests\Prime\TestCase;

class AddToStorageListenerTest extends TestCase
{
    /**
     * @return void
     */
    public function testAddToStorageListener()
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', array());

        $listener = new AddToStorageListener();
        $eventDispatcher->addSubscriber($listener);

        $envelopes = array(
            new Envelope(new Notification(), new WhenStamp(false)),
            new Envelope(new Notification()),
            new Envelope(new Notification(), new UnlessStamp(true)),
            new Envelope(new Notification()),
        );
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $this->assertEquals(array($envelopes[1], $envelopes[3]), $event->getEnvelopes());
    }
}
