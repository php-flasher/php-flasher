<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Flasher\Prime\Envelope;
use PHPUnit\Framework\TestCase;

final class RendererStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp        = new \Flasher\Prime\Stamp\HandlerStamp('toastr');

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Flasher\Prime\Stamp\HandlerStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\HandlerStamp', $stamp);
        $this->assertSame('toastr', $stamp->getHandler());
    }
}
