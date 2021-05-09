<?php

namespace Flasher\Prime\Tests\Envelope\Stamp;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\HopsStamp;
use PHPUnit\Framework\TestCase;

final class CreatedAtStampTest extends TestCase
{
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp = new CreatedAtStamp();

        $envelop = new Envelope($notification, array($stamp));

        $this->assertSame($stamp, $envelop->get('Flasher\Prime\Stamp\CreatedAtStamp'));
        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
    }

    public function testCompare()
    {
        $createdAt1 = new CreatedAtStamp(new \DateTime('+2 h'));
        $createdAt2 = new CreatedAtStamp(new \DateTime('+1 h'));

        $this->assertNotNull($createdAt1->compare($createdAt2));
        $this->assertSame(1, $createdAt1->compare(new HopsStamp(1)));
    }
}
