<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\Notification;
use PHPUnit\Framework\TestCase;

final class NotificationTest extends TestCase
{
    public function testType(): void
    {
        $notification = new Notification();

        $this->assertSame('', $notification->getType());

        $notification->setType('success');

        $this->assertSame('success', $notification->getType());
    }

    public function testMessage(): void
    {
        $notification = new Notification();

        $this->assertSame('', $notification->getMessage());

        $notification->setMessage('success message');

        $this->assertSame('success message', $notification->getMessage());
    }

    public function testTitle(): void
    {
        $notification = new Notification();

        $this->assertSame('', $notification->getTitle());

        $notification->setTitle('success title');

        $this->assertSame('success title', $notification->getTitle());
    }

    public function testOptions(): void
    {
        $notification = new Notification();

        $this->assertSame([], $notification->getOptions());

        $notification->setOptions(['timeout' => 2500]);

        $this->assertSame(['timeout' => 2500], $notification->getOptions());
    }

    public function testOption(): void
    {
        $notification = new Notification();

        $this->assertNull($notification->getOption('timeout'));

        $notification->setOption('timeout', 2500);

        $this->assertSame(2500, $notification->getOption('timeout'));
    }

    public function testUnsetOption(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 2500, 'position' => 'center']);

        $this->assertSame(['timeout' => 2500, 'position' => 'center'], $notification->getOptions());

        $notification->unsetOption('timeout');

        $this->assertSame(['position' => 'center'], $notification->getOptions());
    }

    public function testToArray(): void
    {
        $notification = new Notification();
        $notification->setType('success');
        $notification->setTitle('PHPFlasher');
        $notification->setMessage('success message');
        $notification->setOptions(['timeout' => 2500, 'position' => 'center']);

        $this->assertSame([
            'title' => 'PHPFlasher',
            'message' => 'success message',
            'type' => 'success',
            'options' => ['timeout' => 2500, 'position' => 'center'],
        ], $notification->toArray());
    }
}
