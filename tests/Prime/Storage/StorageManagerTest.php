<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Tests\Prime\TestCase;

final class StorageManagerTest extends TestCase
{
    public function testGetAllStoredEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
            new Envelope(new Notification(), new IdStamp('3333')),
            new Envelope(new Notification(), new IdStamp('4444')),
        ];

        $storage = $this->getMockBuilder(\Flasher\Prime\Storage\StorageInterface::class)->getMock();
        $storage->expects($this->once())->method('all')->willReturn($envelopes);

        $storageManager = new StorageManager($storage);

        $this->assertEquals($envelopes, $storageManager->all());
    }

    public function testGetFilteredEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222'), new HopsStamp(1), new DelayStamp(0)),
            new Envelope(new Notification(), new IdStamp('3333')),
            new Envelope(new Notification(), new IdStamp('4444')),
        ];

        $storage = $this->getMockBuilder(\Flasher\Prime\Storage\StorageInterface::class)->getMock();
        $storage->expects($this->once())->method('all')->willReturn($envelopes);

        $storageManager = new StorageManager($storage);

        $this->assertEquals([$envelopes[1]], $storageManager->filter());
    }

    public function testAddEnvelopes(): void
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

    public function testUpdateEnvelopes(): void
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

    public function testRemoveEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
            new Envelope(new Notification(), new IdStamp('3333')),
            new Envelope(new Notification(), new IdStamp('4444')),
        ];

        $storageManager = new StorageManager();
        $storageManager->add($envelopes);

        $storageManager->remove([
            new Envelope(new Notification(), new IdStamp('2222')),
            new Envelope(new Notification(), new IdStamp('3333')),
        ]);

        $this->assertEquals([$envelopes[0], $envelopes[3]], $storageManager->all());
    }

    public function testClearEnvelopes(): void
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
