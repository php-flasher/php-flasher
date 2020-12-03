<?php

namespace Flasher\Prime\Tests\Notification;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Tests\TestCase;

final class NotificationTest extends TestCase
{
    public function testNotification()
    {
        $notification = new Notification('message', 'type', array('timer' => 5000));

        $this->assertSame('type', $notification->getType());
        $this->assertSame('message', $notification->getMessage());
        $this->assertSame(array('timer' => 5000), $notification->getOptions());
    }

    public function testAddOption()
    {
        $notification = new Notification('message', 'type', array('timer' => 5000));
        $notification->setOption('toast', true);

        $this->assertSame(array('timer' => 5000, 'toast' => true), $notification->getOptions());

        $notification->unsetOption('timer');

        $this->assertSame(array('toast' => true), $notification->getOptions());
    }
}
