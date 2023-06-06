<?php

namespace Flasher\Tests\Prime\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Tests\Prime\TestCase;

class StorageManagerTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetAllStoredEnvelopes()
    {
        $envelopes = [
            new Envelope(new Notification(), new UuidStamp('1111')),
            new Envelope(new Notification(), new UuidStamp('2222')),
            new Envelope(new Notification(), new UuidStamp('3333')),
            new Envelope(new Notification(), new UuidStamp('4444')),
        ];

        $storage = $this->getMockBuilder('Flasher\Prime\Storage\StorageInterface')->getMock();
        $storage->expects($this->once())->method('all')->willReturn($envelopes);

        $storageManager = new StorageManager($storage);

        $this->assertEquals($envelopes, $storageManager->all());
    }

    /**
     * @return void
     */
    public function testGetFilteredEnvelopes()
    {
        $envelopes = [
            new Envelope(new Notification(), new UuidStamp('1111')),
            new Envelope(new Notification(), new UuidStamp('2222'), new HopsStamp(1), new DelayStamp(0)),
            new Envelope(new Notification(), new UuidStamp('3333')),
            new Envelope(new Notification(), new UuidStamp('4444')),
        ];

        $storage = $this->getMockBuilder('Flasher\Prime\Storage\StorageInterface')->getMock();
        $storage->expects($this->once())->method('all')->willReturn($envelopes);

        $storageManager = new StorageManager($storage);

        $this->assertEquals([$envelopes[1]], $storageManager->filter());
    }

    /**
     * @return void
     */
    public function testAddEnvelopes()
    {
        $envelopes = [
             new Envelope(new Notification()),
             new Envelope(new Notification()),
             new Envelope(new Notification()),
             new Envelope(new Notification()),
         ];

        $storageManager = new StorageManager();
        $storageManager->add($envelopes);

        $this->assertEquals($envelopes, $storageManager->all());
    }

    /**
     * @return void
     */
    public function testUpdateEnvelopes()
    {
        $envelopes = [
             new Envelope(new Notification()),
             new Envelope(new Notification()),
             new Envelope(new Notification()),
             new Envelope(new Notification()),
         ];

        $storageManager = new StorageManager();
        $storageManager->update($envelopes);

        $this->assertEquals($envelopes, $storageManager->all());
    }

    /**
     * @return void
     */
    public function testRemoveEnvelopes()
    {
        $envelopes = [
             new Envelope(new Notification(), new UuidStamp('1111')),
             new Envelope(new Notification(), new UuidStamp('2222')),
             new Envelope(new Notification(), new UuidStamp('3333')),
             new Envelope(new Notification(), new UuidStamp('4444')),
         ];

        $storageManager = new StorageManager();
        $storageManager->add($envelopes);

        $storageManager->remove([
            new Envelope(new Notification(), new UuidStamp('2222')),
            new Envelope(new Notification(), new UuidStamp('3333')),
        ]);

        $this->assertEquals([$envelopes[0], $envelopes[3]], $storageManager->all());
    }

    /**
     * @return void
     */
    public function testClearEnvelopes()
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $storageManager = new StorageManager();
        $storageManager->add($envelopes);

        $storageManager->clear();

        $this->assertEquals([], $storageManager->all());
    }
}
