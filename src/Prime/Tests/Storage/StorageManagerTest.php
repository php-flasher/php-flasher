<?php

namespace Flasher\Prime\Tests\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Storage\ArrayStorage;
use Flasher\Prime\Storage\StorageManager;
use PHPUnit\Framework\TestCase;

class StorageManagerTest extends TestCase
{
    public function testAll()
    {
        $storageManager = new StorageManager(new ArrayStorage(), new EventDispatcher());
        $envelopes = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification());
            $storageManager->add($envelopes[$index]);
        }

        $this->assertCount(5, $storageManager->all());
    }

    public function testClear()
    {
        $storageManager = new StorageManager(new ArrayStorage(), new EventDispatcher());
        $envelopes = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification());
            $storageManager->add($envelopes[$index]);
        }

        $storageManager->clear();

        $this->assertSame(array(), $storageManager->all());
    }

    public function testAdd()
    {
        $storageManager = new StorageManager(new ArrayStorage(), new EventDispatcher());
        $storageManager->add(new Envelope(new Notification()));

        $envelopes = $storageManager->all();

        $this->assertCount(1, $envelopes);

        $uuid = $envelopes[0]->get('Flasher\Prime\Stamp\UuidStamp');
        $this->assertNull($uuid);
    }
}
