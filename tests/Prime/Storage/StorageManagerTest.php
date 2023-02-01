<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
        $envelopes = array(
            new Envelope(new Notification(), new UuidStamp('1111')),
            new Envelope(new Notification(), new UuidStamp('2222')),
            new Envelope(new Notification(), new UuidStamp('3333')),
            new Envelope(new Notification(), new UuidStamp('4444')),
        );

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
        $envelopes = array(
            new Envelope(new Notification(), new UuidStamp('1111')),
            new Envelope(new Notification(), new UuidStamp('2222'), new HopsStamp(1), new DelayStamp(0)),
            new Envelope(new Notification(), new UuidStamp('3333')),
            new Envelope(new Notification(), new UuidStamp('4444')),
        );

        $storage = $this->getMockBuilder('Flasher\Prime\Storage\StorageInterface')->getMock();
        $storage->expects($this->once())->method('all')->willReturn($envelopes);

        $storageManager = new StorageManager($storage);

        $this->assertEquals(array($envelopes[1]), $storageManager->filter());
    }

    /**
     * @return void
     */
    public function testAddEnvelopes()
    {
        $envelopes = array(
             new Envelope(new Notification()),
             new Envelope(new Notification()),
             new Envelope(new Notification()),
             new Envelope(new Notification()),
         );

        $storageManager = new StorageManager();
        $storageManager->add($envelopes);

        $this->assertEquals($envelopes, $storageManager->all());
    }

    /**
     * @return void
     */
    public function testUpdateEnvelopes()
    {
        $envelopes = array(
             new Envelope(new Notification()),
             new Envelope(new Notification()),
             new Envelope(new Notification()),
             new Envelope(new Notification()),
         );

        $storageManager = new StorageManager();
        $storageManager->update($envelopes);

        $this->assertEquals($envelopes, $storageManager->all());
    }

    /**
     * @return void
     */
    public function testRemoveEnvelopes()
    {
        $envelopes = array(
             new Envelope(new Notification(), new UuidStamp('1111')),
             new Envelope(new Notification(), new UuidStamp('2222')),
             new Envelope(new Notification(), new UuidStamp('3333')),
             new Envelope(new Notification(), new UuidStamp('4444')),
         );

        $storageManager = new StorageManager();
        $storageManager->add($envelopes);

        $storageManager->remove(array(
            new Envelope(new Notification(), new UuidStamp('2222')),
            new Envelope(new Notification(), new UuidStamp('3333')),
        ));

        $this->assertEquals(array($envelopes[0], $envelopes[3]), $storageManager->all());
    }

    /**
     * @return void
     */
    public function testClearEnvelopes()
    {
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $storageManager = new StorageManager();
        $storageManager->add($envelopes);

        $storageManager->clear();

        $this->assertEquals(array(), $storageManager->all());
    }
}
