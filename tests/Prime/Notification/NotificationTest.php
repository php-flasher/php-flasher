<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

final class NotificationTest extends TestCase
{
    public function testType(): void
    {
        $notification = new Notification();

        $this->assertEquals('', $notification->getType());

        $notification->setType('success');

        $this->assertEquals('success', $notification->getType());
    }

    public function testMessage(): void
    {
        $notification = new Notification();

        $this->assertEquals('', $notification->getMessage());

        $notification->setMessage('success message');

        $this->assertEquals('success message', $notification->getMessage());
    }

    public function testTitle(): void
    {
        $notification = new Notification();

        $this->assertEquals('', $notification->getTitle());

        $notification->setTitle('success title');

        $this->assertEquals('success title', $notification->getTitle());
    }

    public function testOptions(): void
    {
        $notification = new Notification();

        $this->assertEquals([], $notification->getOptions());

        $notification->setOptions(['timeout' => 2500]);

        $this->assertEquals(['timeout' => 2500], $notification->getOptions());
    }

    public function testOption(): void
    {
        $notification = new Notification();

        $this->assertNull($notification->getOption('timeout'));

        $notification->setOption('timeout', 2500);

        $this->assertEquals(2500, $notification->getOption('timeout'));
    }

    public function testUnsetOption(): void
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 2500, 'position' => 'center']);

        $this->assertEquals(['timeout' => 2500, 'position' => 'center'], $notification->getOptions());

        $notification->unsetOption('timeout');

        $this->assertEquals(['position' => 'center'], $notification->getOptions());
    }

    public function testToArray(): void
    {
        $notification = new Notification();
        $notification->setType('success');
        $notification->setTitle('PHPFlasher');
        $notification->setMessage('success message');
        $notification->setOptions(['timeout' => 2500, 'position' => 'center']);

        $this->assertEquals([
            'type' => 'success',
            'title' => 'PHPFlasher',
            'message' => 'success message',
            'options' => ['timeout' => 2500, 'position' => 'center'],
        ], $notification->toArray());
    }
}
