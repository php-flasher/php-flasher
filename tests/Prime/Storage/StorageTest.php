<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Flasher\Prime\Storage\Storage;
use PHPUnit\Framework\TestCase;

final class StorageTest extends TestCase
{
    private Storage $storage;

    protected function setUp(): void
    {
        $this->storage = new Storage(new ArrayBag());
    }

    public function testAllMethod(): void
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

        $this->storage->add(...$envelopes[0]);
        $this->storage->add(...$envelopes[1]);

        $this->assertEquals([...$envelopes[0], ...$envelopes[1]], $this->storage->all());
        $this->assertNotEquals(array_reverse([...$envelopes[0], ...$envelopes[1]]), $this->storage->all());
    }

    public function testAddMethod(): void
    {
        $envelope = new Envelope(new Notification(), new IdStamp('1111'));

        $this->storage->add($envelope);

        $this->assertContains($envelope, $this->storage->all());
    }

    public function testUpdateMethod(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $this->storage->add(...$envelopes);
        $this->assertContains($envelopes[1], $this->storage->all());

        $envelopes[1] = new Envelope(new Notification(), new IdStamp('3333'));

        $this->storage->update(...$envelopes);
        $this->assertContains($envelopes[1], $this->storage->all());
        $this->assertNotContains('Notification2', $this->storage->all());
    }

    public function testRemoveMethod(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $this->storage->add(...$envelopes);

        $this->assertContains($envelopes[1], $this->storage->all());

        $this->storage->remove($envelopes[1]);

        $this->assertNotContains($envelopes[1], $this->storage->all());
    }

    public function testClearMethod(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $this->storage->add(...$envelopes);

        $this->assertNotEmpty($this->storage->all());

        $this->storage->clear();

        $this->assertEmpty($this->storage->all());
    }
}
