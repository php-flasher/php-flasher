<?php

namespace Flasher\Laravel\Tests\Storage;

use Flasher\Laravel\Storage\Storage;
use Flasher\Laravel\Tests\TestCase;
use Flasher\Prime\Envelope;
use Flasher\Prime\Notification\Notification;

final class StorageTest extends TestCase
{
    public function test_simple()
    {
        $session = new Storage($this->app->make('session'));

        $envelope = new Envelope(new Notification('success', 'message'));
        $session->add($envelope);

        $this->assertEquals(array($envelope), $session->get());
    }
}
