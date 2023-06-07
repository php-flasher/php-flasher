<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Tests\Prime\TestCase;

final class EnvelopeTest extends TestCase
{
    public function testConstruct(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $stamp = $this->getMockBuilder(\Flasher\Prime\Stamp\StampInterface::class)->getMock();

        $envelope = new Envelope($notification, [$stamp]);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp::class => $stamp], $envelope->all());
    }

    public function testWrap(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $stamp = $this->getMockBuilder(\Flasher\Prime\Stamp\StampInterface::class)->getMock();

        $envelope = Envelope::wrap($notification, [$stamp]);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp::class => $stamp], $envelope->all());
    }

    public function testWith(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $stamp1 = $this->getMockBuilder(\Flasher\Prime\Stamp\StampInterface::class)->getMock();
        $stamp2 = $this->getMockBuilder(\Flasher\Prime\Stamp\StampInterface::class)->getMock();

        $envelope = new Envelope($notification);
        $envelope->with([$stamp1, $stamp2]);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp1::class => $stamp1, $stamp2::class => $stamp2], $envelope->all());
    }

    public function testWithStamp(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $stamp = $this->getMockBuilder(\Flasher\Prime\Stamp\StampInterface::class)->getMock();

        $envelope = new Envelope($notification);
        $envelope->withStamp($stamp);

        $this->assertContains($stamp, $envelope->all());
    }

    public function testWithout(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $stamp1 = new HopsStamp(2);
        $stamp2 = new HandlerStamp('flasher');
        $stamp3 = new PresetStamp('entity_saved');

        $envelope = new Envelope($notification);
        $envelope->with([$stamp1, $stamp2, $stamp3]);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp1::class => $stamp1, $stamp2::class => $stamp2, $stamp3::class => $stamp3], $envelope->all());

        $envelope->without($stamp1);

        $this->assertEquals([$stamp2::class => $stamp2], $envelope->all());
    }

    public function testWithoutStamp(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $stamp1 = new HopsStamp(2);
        $stamp2 = new HandlerStamp('flasher');
        $stamp3 = new PresetStamp('entity_saved');

        $envelope = new Envelope($notification);
        $envelope->with([$stamp1, $stamp2, $stamp3]);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamp1::class => $stamp1, $stamp2::class => $stamp2, $stamp3::class => $stamp3], $envelope->all());

        $envelope->withoutStamp($stamp1);

        $this->assertEquals([$stamp2::class => $stamp2, $stamp3::class => $stamp3], $envelope->all());
    }

    public function testGet(): void
    {
        $notification = $this->getMockBuilder('\\'.\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $stamps = [
            new HopsStamp(2),
            new HandlerStamp('flasher'),
            new PresetStamp('entity_saved'),
        ];

        $envelope = new Envelope($notification, $stamps);

        $this->assertEquals($notification, $envelope->getNotification());

        $last = $envelope->get($stamps[0]::class);

        $this->assertEquals($stamps[0], $last);
        $this->assertEquals($last, $envelope->get($stamps[0]::class));

        $this->assertNull($envelope->get('NotFoundStamp')); // @phpstan-ignore-line
    }

    public function testAll(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $stamps = [
            new HopsStamp(2),
            new HandlerStamp('flasher'),
            new PresetStamp('entity_saved'),
        ];

        $envelope = new Envelope($notification, $stamps);

        $this->assertEquals($notification, $envelope->getNotification());
        $this->assertEquals([$stamps[0]::class => $stamps[0], $stamps[1]::class => $stamps[1], $stamps[2]::class => $stamps[2]], $envelope->all());
    }

    public function testGetNotification(): void
    {
        $notification = new Notification();

        $envelope = new Envelope($notification);

        $this->assertEquals($notification, $envelope->getNotification());
    }

    public function testGetType(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('getType')->willReturn('success');

        $envelope = new Envelope($notification);

        $this->assertEquals('success', $envelope->getType());
    }

    public function testSetType(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('setType');

        $envelope = new Envelope($notification);
        $envelope->setType('success');
    }

    public function testGetMessage(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('getMessage')->willReturn('success message');

        $envelope = new Envelope($notification);

        $this->assertEquals('success message', $envelope->getMessage());
    }

    public function testSetMessage(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('setMessage');

        $envelope = new Envelope($notification);
        $envelope->setMessage('success message');
    }

    public function testGetTitle(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('getTitle')->willReturn('success title');

        $envelope = new Envelope($notification);

        $this->assertEquals('success title', $envelope->getTitle());
    }

    public function testSetTitle(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('setTitle');

        $envelope = new Envelope($notification);
        $envelope->setTitle('success title');
    }

    public function testGetOptions(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('getOptions')->willReturn(['timeout' => 2500]);

        $envelope = new Envelope($notification);

        $this->assertEquals(['timeout' => 2500], $envelope->getOptions());
    }

    public function testSetOptions(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('setOptions');

        $envelope = new Envelope($notification);
        $envelope->setOptions(['timeout' => 2500]);
    }

    public function testGetOption(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('getOption')->willReturn(2500);

        $envelope = new Envelope($notification);

        $this->assertEquals(2500, $envelope->getOption('timeout'));
    }

    public function testSetOption(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('setOption');

        $envelope = new Envelope($notification);
        $envelope->setOption('timeout', 2500);
    }

    public function testUnsetOption(): void
    {
        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('unsetOption');

        $envelope = new Envelope($notification);
        $envelope->unsetOption('timeout');
    }

    public function testToArray(): void
    {
        $array = [
            'title' => 'PHPFlasher',
            'message' => 'success message',
            'options' => ['timeout' => 2500],
        ];

        $notification = $this->getMockBuilder(\Flasher\Prime\Notification\NotificationInterface::class)->getMock();
        $notification->expects($this->once())->method('toArray')->willReturn($array);

        $envelope = new Envelope($notification, new HandlerStamp('flasher'));

        $this->assertEquals(['notification' => $array, 'handler' => 'flasher'], $envelope->toArray());
    }

    public function testCallDynamicCallToNotification(): void
    {
        $notification = new DynamicNotification();
        $envelope = new Envelope($notification);

        $this->assertEquals('foobar', $envelope->foo());
    }
}
