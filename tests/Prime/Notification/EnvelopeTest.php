<?php

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Tests\Prime\TestCase;

final class EnvelopeTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstruct()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp = $this->getMockBuilder('Flasher\Prime\Stamp\StampInterface')->getMock();

        $envelope = new Envelope($notification, [$stamp]);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp::class => $stamp], $envelope->all());
    }

    /**
     * @return void
     */
    public function testWrap()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp = $this->getMockBuilder('Flasher\Prime\Stamp\StampInterface')->getMock();

        $envelope = Envelope::wrap($notification, [$stamp]);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp::class => $stamp], $envelope->all());
    }

    /**
     * @return void
     */
    public function testWith()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp1 = $this->getMockBuilder('Flasher\Prime\Stamp\StampInterface')->getMock();
        $stamp2 = $this->getMockBuilder('Flasher\Prime\Stamp\StampInterface')->getMock();

        $envelope = new Envelope($notification);
        $envelope->with($stamp1, $stamp2);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp1::class => $stamp1, $stamp2::class => $stamp2], $envelope->all());
    }

    /**
     * @return void
     */
    public function testWithStamp()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp = $this->getMockBuilder('Flasher\Prime\Stamp\StampInterface')->getMock();

        $envelope = new Envelope($notification);
        $envelope->withStamp($stamp);

        $this->assertContains($stamp, $envelope->all());
    }

    /**
     * @return void
     */
    public function testWithout()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp1 = new HopsStamp(2);
        $stamp2 = new HandlerStamp('flasher');
        $stamp3 = new PresetStamp('entity_saved');

        $envelope = new Envelope($notification);
        $envelope->with($stamp1, $stamp2, $stamp3);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp1::class => $stamp1, $stamp2::class => $stamp2, $stamp3::class => $stamp3], $envelope->all());

        $envelope->without($stamp1, $stamp3);

        $this->assertEquals([$stamp2::class => $stamp2], $envelope->all());
    }

    /**
     * @return void
     */
    public function testWithoutStamp()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamp1 = new HopsStamp(2);
        $stamp2 = new HandlerStamp('flasher');
        $stamp3 = new PresetStamp('entity_saved');

        $envelope = new Envelope($notification);
        $envelope->with($stamp1, $stamp2, $stamp3);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp1::class => $stamp1, $stamp2::class => $stamp2, $stamp3::class => $stamp3], $envelope->all());

        $envelope->withoutStamp($stamp1);

        $this->assertEquals([$stamp2::class => $stamp2, $stamp3::class => $stamp3], $envelope->all());
    }

    /**
     * @return void
     */
    public function testGet()
    {
        $notification = $this->getMockBuilder('\Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamps = [
            new HopsStamp(2),
            new HandlerStamp('flasher'),
            new PresetStamp('entity_saved'),
        ];

        $envelope = new Envelope($notification, $stamps);

        $this->assertEquals($notification, $envelope->getNotification());

        $last = $envelope->get(\get_class($stamps[0]));

        $this->assertEquals($stamps[0], $last);
        $this->assertEquals($last, $envelope->get(\get_class($stamps[0])));

        $this->assertNull($envelope->get('NotFoundStamp')); // @phpstan-ignore-line
    }

    /**
     * @return void
     */
    public function testAll()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamps = [
            new HopsStamp(2),
            new HandlerStamp('flasher'),
            new PresetStamp('entity_saved'),
        ];

        $envelope = new Envelope($notification, $stamps);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([\get_class($stamps[0]) => $stamps[0], \get_class($stamps[1]) => $stamps[1], \get_class($stamps[2]) => $stamps[2]], $envelope->all());
    }

    /**
     * @return void
     */
    public function testGetNotification()
    {
        $notification = new Notification();

        $envelope = new Envelope($notification);

        $this->assertEquals($notification, $envelope->getNotification());
    }

    /**
     * @return void
     */
    public function testGetType()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('getType')->willReturn('success');

        $envelope = new Envelope($notification);

        $this->assertEquals('success', $envelope->getType());
    }

    /**
     * @return void
     */
    public function testSetType()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('setType');

        $envelope = new Envelope($notification);
        $envelope->setType('success');
    }

    /**
     * @return void
     */
    public function testGetMessage()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('getMessage')->willReturn('success message');

        $envelope = new Envelope($notification);

        $this->assertEquals('success message', $envelope->getMessage());
    }

    /**
     * @return void
     */
    public function testSetMessage()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('setMessage');

        $envelope = new Envelope($notification);
        $envelope->setMessage('success message');
    }

    /**
     * @return void
     */
    public function testGetTitle()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('getTitle')->willReturn('success title');

        $envelope = new Envelope($notification);

        $this->assertEquals('success title', $envelope->getTitle());
    }

    /**
     * @return void
     */
    public function testSetTitle()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('setTitle');

        $envelope = new Envelope($notification);
        $envelope->setTitle('success title');
    }

    /**
     * @return void
     */
    public function testGetOptions()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('getOptions')->willReturn(['timeout' => 2500]);

        $envelope = new Envelope($notification);

        $this->assertEquals(['timeout' => 2500], $envelope->getOptions());
    }

    /**
     * @return void
     */
    public function testSetOptions()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('setOptions');

        $envelope = new Envelope($notification);
        $envelope->setOptions(['timeout' => 2500]);
    }

    /**
     * @return void
     */
    public function testGetOption()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('getOption')->willReturn(2500);

        $envelope = new Envelope($notification);

        $this->assertEquals(2500, $envelope->getOption('timeout'));
    }

    /**
     * @return void
     */
    public function testSetOption()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('setOption');

        $envelope = new Envelope($notification);
        $envelope->setOption('timeout', 2500);
    }

    /**
     * @return void
     */
    public function testUnsetOption()
    {
        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('unsetOption');

        $envelope = new Envelope($notification);
        $envelope->unsetOption('timeout');
    }

    /**
     * @return void
     */
    public function testToArray()
    {
        $array = [
            'title' => 'PHPFlasher',
            'message' => 'success message',
            'options' => ['timeout' => 2500],
        ];

        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $notification->expects($this->once())->method('toArray')->willReturn($array);

        $envelope = new Envelope($notification, new HandlerStamp('flasher'));

        $this->assertEquals(['notification' => $array, 'handler' => 'flasher'], $envelope->toArray());
    }

    /**
     * @return void
     */
    public function testCallDynamicCallToNotification()
    {
        $notification = new DynamicNotification();
        $envelope = new Envelope($notification);

        $this->assertEquals('foobar', $envelope->foo());
    }
}

class DynamicNotification extends Notification
{
    public function foo()
    {
        return 'foobar';
    }
}
