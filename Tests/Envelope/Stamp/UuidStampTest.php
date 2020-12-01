<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Notify\Envelope;
use PHPUnit\Framework\TestCase;

final class UuidStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamp        = new \Flasher\Prime\TestsStamp\UuidStamp();

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Flasher\Prime\TestsStamp\UuidStamp'));
        $this->assertInstanceOf('Flasher\Prime\TestsStamp\UuidStamp', $stamp);
        $this->assertNotEmpty($stamp->getUuid());
    }
}
