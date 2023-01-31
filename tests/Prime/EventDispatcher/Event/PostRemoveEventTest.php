<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\Event;

use Flasher\Prime\EventDispatcher\Event\PostRemoveEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

class PostRemoveEventTest extends TestCase
{
    /**
     * @return void
     */
    public function testPostRemoveEvent()
    {
        $envelopesToRemove = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $envelopesToKeep = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $event = new PostRemoveEvent($envelopesToRemove, $envelopesToKeep);

        $this->assertEquals($envelopesToRemove, $event->getEnvelopesToRemove());
        $this->assertEquals($envelopesToKeep, $event->getEnvelopesToKeep());
    }
}
