<?php

namespace Flasher\Tests\Prime\Notification;

use Flasher\Prime\Notification\Notification;
use Flasher\Tests\Prime\TestCase;

class NotificationTest extends TestCase
{
    /**
     * @return void
     */
    public function testType()
    {
        $notification = new Notification();

        $this->assertNull($notification->getType());

        $notification->setType('success');

        $this->assertEquals('success', $notification->getType());
    }

    /**
     * @return void
     */
    public function testMessage()
    {
        $notification = new Notification();

        $this->assertNull($notification->getMessage());

        $notification->setMessage('success message');

        $this->assertEquals('success message', $notification->getMessage());
    }

    /**
     * @return void
     */
    public function testTitle()
    {
        $notification = new Notification();

        $this->assertNull($notification->getTitle());

        $notification->setTitle('success title');

        $this->assertEquals('success title', $notification->getTitle());
    }

    /**
     * @return void
     */
    public function testOptions()
    {
        $notification = new Notification();

        $this->assertEquals([], $notification->getOptions());

        $notification->setOptions(['timeout' => 2500]);

        $this->assertEquals(['timeout' => 2500], $notification->getOptions());
    }

    /**
     * @return void
     */
    public function testOption()
    {
        $notification = new Notification();

        $this->assertNull($notification->getOption('timeout'));

        $notification->setOption('timeout', 2500);

        $this->assertEquals(2500, $notification->getOption('timeout'));
    }

    /**
     * @return void
     */
    public function testUnsetOption()
    {
        $notification = new Notification();
        $notification->setOptions(['timeout' => 2500, 'position' => 'center']);

        $this->assertEquals(['timeout' => 2500, 'position' => 'center'], $notification->getOptions());

        $notification->unsetOption('timeout');

        $this->assertEquals(['position' => 'center'], $notification->getOptions());
    }

    /**
     * @return void
     */
    public function testToArray()
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
