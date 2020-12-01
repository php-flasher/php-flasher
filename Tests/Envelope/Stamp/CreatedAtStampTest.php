<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Notify\Envelope;
use Flasher\Prime\TestsStamp\CreatedAtStamp;
use Flasher\Prime\TestsStamp\ReplayStamp;
use PHPUnit\Framework\TestCase;

final class CreatedAtStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamp        = new CreatedAtStamp();

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Flasher\Prime\TestsStamp\CreatedAtStamp'));
        $this->assertInstanceOf('Flasher\Prime\TestsStamp\StampInterface', $stamp);
    }

    public function testCompare()
    {
        $createdAt1 = new \Flasher\Prime\TestsStamp\CreatedAtStamp(new \DateTime('+2 h'));
        $createdAt2 = new \Flasher\Prime\TestsStamp\CreatedAtStamp(new \DateTime('+1 h'));

        $this->assertFalse($createdAt1->compare($createdAt2));
        $this->assertSame(0, $createdAt1->compare(new ReplayStamp(1)));
    }
}
