<?php

namespace Flasher\Prime\Tests\Storage;

use Notify\Envelope;
use Flasher\Prime\TestsNotification\Notification;
use Flasher\Prime\TestsStamp\ReplayStamp;
use Flasher\Prime\TestsStamp\UuidStamp;
use Flasher\Prime\TestsStorage\ArrayStorage;
use Flasher\Prime\TestsStorage\StorageManager;
use PHPUnit\Framework\TestCase;

class StorageManagerTest extends TestCase
{
    public function testAll()
    {
        $storageManager = new StorageManager(new ArrayStorage());
        $envelopes      = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification('success', 'success message'));
            $storageManager->add($envelopes[$index]);
        }

        $this->assertCount(5, $storageManager->all());
    }

    public function testClear()
    {
        $storageManager = new StorageManager(new ArrayStorage());
        $envelopes      = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification('success', 'success message'));
            $storageManager->add($envelopes[$index]);
        }

        $storageManager->clear();

        $this->assertSame(array(), $storageManager->all());
    }

    public function testAdd()
    {
        $storageManager = new StorageManager(new ArrayStorage());
        $storageManager->add(new Envelope(new Notification('success')));

        $envelopes = $storageManager->all();

        $this->assertCount(1, $envelopes);

        $uuid = $envelopes[0]->get('Flasher\Prime\TestsStamp\UuidStamp');
        $this->assertNotNull($uuid);
    }

    public function testFlush()
    {
        $storageManager = new StorageManager(new ArrayStorage());

        $envelope = new Envelope(
            new Notification('error message', 'error'),
            new ReplayStamp(2),
            new UuidStamp('fake-uuid')
        );
        $storageManager->add($envelope);

        $envelopes = array();
        foreach (range(0, 2) as $index) {
            $envelopes[$index] = new Envelope(new Notification('success message', 'success'));
            $storageManager->add($envelopes[$index]);
        }
        $envelopes[] = $envelope;

        $storageManager->flush($envelopes);

        $this->assertSame(array('fake-uuid'), array_keys(UuidStamp::indexWithUuid($storageManager->all())));
    }
}
