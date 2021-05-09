<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\UuidStamp;
use PHPUnit\Framework\TestCase;

final class UuidStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp = new UuidStamp();

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Flasher\Prime\Stamp\UuidStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\UuidStamp', $stamp);
        $this->assertNotEmpty($stamp->getUuid());
    }
}
