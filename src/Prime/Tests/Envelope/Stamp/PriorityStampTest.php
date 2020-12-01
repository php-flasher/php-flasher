<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Notify\Envelope;
use Flasher\Prime\TestsStamp\PriorityStamp;
use PHPUnit\Framework\TestCase;

final class PriorityStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamp        = new PriorityStamp(5);

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Flasher\Prime\TestsStamp\PriorityStamp'));
        $this->assertInstanceOf('Flasher\Prime\TestsStamp\StampInterface', $stamp);
        $this->assertSame(5, $stamp->getPriority());
    }

    public function testCompare()
    {
        $stamp1 = new PriorityStamp(1);
        $stamp2 = new \Flasher\Prime\TestsStamp\PriorityStamp(2);

        $this->assertFalse($stamp1->compare($stamp2));
        $this->assertSame(0, $stamp1->compare(new \Flasher\Prime\TestsStamp\ReplayStamp(1)));
    }
}
