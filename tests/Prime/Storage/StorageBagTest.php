<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Flasher\Prime\Storage\Storage;
use PHPUnit\Framework\TestCase;

final class StorageBagTest extends TestCase
{
    public function testAddEnvelopes(): void
    {
        $envelopes = [
            [
                new Envelope(new Notification(), new IdStamp('1111')),
                new Envelope(new Notification(), new IdStamp('2222')),
            ],
            [
                new Envelope(new Notification(), new IdStamp('3333')),
                new Envelope(new Notification(), new IdStamp('4444')),
            ],
        ];

        $storageBag = new Storage(new ArrayBag());
        $storageBag->add(...$envelopes[0]);
        $storageBag->add(...$envelopes[1]);

        $this->assertEquals([...$envelopes[0], ...$envelopes[1]], $storageBag->all());
    }

    public function testUpdateEnvelopes(): void
    {
        $envelopes = [
            [
                new Envelope(new Notification(), new IdStamp('1111')),
                new Envelope(new Notification(), new IdStamp('2222')),
            ],
            [
                new Envelope(new Notification(), new IdStamp('3333')),
                new Envelope(new Notification(), new IdStamp('4444')),
            ],
        ];

        $storageBag = new Storage(new ArrayBag());
        $storageBag->update(...$envelopes[0]);
        $storageBag->update(...$envelopes[1]);

        $this->assertEquals([...$envelopes[0], ...$envelopes[1]], $storageBag->all());
    }

    public function testRemoveEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
            new Envelope(new Notification(), new IdStamp('3333')),
            new Envelope(new Notification(), new IdStamp('4444')),
        ];

        $storageBag = new Storage(new ArrayBag());
        $storageBag->add(...$envelopes);

        $storageBag->remove(new Envelope(new Notification(), new IdStamp('2222')));

        unset($envelopes[1]);

        $this->assertEquals(array_values($envelopes), $storageBag->all());
    }
}
