<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Notify\Envelope;
use PHPUnit\Framework\TestCase;

final class LifeStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamp        = new \Flasher\Prime\TestsStamp\ReplayStamp(5);

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Flasher\Prime\TestsStamp\ReplayStamp'));
        $this->assertInstanceOf('Flasher\Prime\TestsStamp\ReplayStamp', $stamp);
        $this->assertSame(5, $stamp->getCount());
    }
}
