<?php

namespace Flasher\Tests\Prime\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageBag;
use Flasher\Tests\Prime\TestCase;

class StorageBagTest extends TestCase
{
    /**
     * @return void
     */
    public function testAddEnvelopes()
    {
        $envelopes = [
            [
                new Envelope(new Notification(), new UuidStamp('1111')),
                new Envelope(new Notification(), new UuidStamp('2222')),
            ],
            [
                new Envelope(new Notification(), new UuidStamp('3333')),
                new Envelope(new Notification(), new UuidStamp('4444')),
            ],
        ];

        $storageBag = new StorageBag();
        $storageBag->add($envelopes[0]);
        $storageBag->add($envelopes[1]);

        $this->assertEquals(array_merge($envelopes[0], $envelopes[1]), $storageBag->all());
    }

    /**
     * @return void
     */
    public function testUpdateEnvelopes()
    {
        $envelopes = [
            [
                new Envelope(new Notification(), new UuidStamp('1111')),
                new Envelope(new Notification(), new UuidStamp('2222')),
            ],
            [
                new Envelope(new Notification(), new UuidStamp('3333')),
                new Envelope(new Notification(), new UuidStamp('4444')),
            ],
        ];

        $storageBag = new StorageBag();
        $storageBag->update($envelopes[0]);
        $storageBag->update($envelopes[1]);

        $this->assertEquals(array_merge($envelopes[0], $envelopes[1]), $storageBag->all());
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

        $storageBag = new StorageBag();
        $storageBag->add($envelopes);

        $storageBag->remove([
            new Envelope(new Notification(), new UuidStamp('2222')),
        ]);

        unset($envelopes[1]);

        $this->assertEquals(array_values($envelopes), $storageBag->all());
    }
}
