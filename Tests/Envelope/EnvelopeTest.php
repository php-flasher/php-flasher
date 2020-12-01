<?php

namespace Flasher\Prime\Tests\Envelope;

use Notify\Envelope;
use PHPUnit\Framework\TestCase;

final class EnvelopeTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamp        = $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock();

        $envelope = new Envelope($notification, array($stamp));

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamp) => $stamp), $envelope->all());
    }

    public function testWith()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamp1       = $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock();
        $stamp2       = $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock();

        $envelope = new Envelope($notification);
        $envelope->with($stamp1, $stamp2);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamp1) => $stamp1, get_class($stamp2) => $stamp2), $envelope->all());
    }

    public function testWrap()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamp        = $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock();

        $envelope = Envelope::wrap($notification, array($stamp));

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamp) => $stamp), $envelope->all());
    }

    public function testAll()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamps       = array(
            $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock(),
        );

        $envelope = new Envelope($notification, $stamps);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertSame(array(get_class($stamps[0]) => $stamps[3]), $envelope->all());
    }

    public function testGet()
    {
        $notification = $this->getMockBuilder('\Flasher\Prime\TestsNotification\NotificationInterface')->getMock();
        $stamps       = array(
            $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\TestsStamp\StampInterface')->getMock(),
        );

        $envelope = new \Notify\Envelope($notification, $stamps);

        $this->assertSame($notification, $envelope->getNotification());

        $last = $envelope->get(get_class($stamps[0]));

        $this->assertSame($stamps[2], $last);
        $this->assertSame($last, $envelope->get(get_class($stamps[0])));

        $this->assertNull($envelope->get('NotFoundStamp'));
    }
}
