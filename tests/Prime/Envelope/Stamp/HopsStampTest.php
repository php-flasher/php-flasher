<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Envelope\Stamp;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;
use PHPUnit\Framework\TestCase;

final class HopsStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp = new HopsStamp(5);

        $envelop = new Envelope($notification, array($stamp));

        $this->assertEquals($stamp, $envelop->get('Flasher\Prime\Stamp\HopsStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\HopsStamp', $stamp);
        $this->assertEquals(5, $stamp->getAmount());
    }
}
