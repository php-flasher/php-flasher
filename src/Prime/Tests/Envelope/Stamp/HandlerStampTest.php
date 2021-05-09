<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\HandlerStamp;
use PHPUnit\Framework\TestCase;

final class HandlerStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp = new HandlerStamp('toastr');

        $envelop = new Envelope($notification, array($stamp));

        $this->assertEquals($stamp, $envelop->get('Flasher\Prime\Stamp\HandlerStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\HandlerStamp', $stamp);
        $this->assertEquals('toastr', $stamp->getHandler());
    }
}
