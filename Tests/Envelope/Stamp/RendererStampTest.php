<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Notify\Envelope;
use PHPUnit\Framework\TestCase;

final class RendererStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamp        = new \Flasher\Prime\TestsStamp\HandlerStamp('toastr');

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Flasher\Prime\TestsStamp\HandlerStamp'));
        $this->assertInstanceOf('Flasher\Prime\TestsStamp\HandlerStamp', $stamp);
        $this->assertSame('toastr', $stamp->getHandler());
    }
}
