<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel;

use Flasher\Laravel\Storage\SessionBag;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Storage\Storage;

final class StorageTest extends TestCase
{
    public function testInitialState(): void
    {
        $storage = $this->getStorage();
        $this->assertEquals([], $storage->all());
    }

    public function testAddEnvelope(): void
    {
        $storage = $this->getStorage();
        $envelope = new Envelope(new Notification());
        $storage->add($envelope);

        $this->assertEquals([$envelope], $storage->all());
    }

    public function testAddMultipleEnvelopes(): void
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $storage->add(...$envelopes);
        $this->assertEquals($envelopes, $storage->all());
    }

    public function testUpdateEnvelopes(): void
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification(), [
                new IdStamp(),
            ]),
            new Envelope(new Notification(), [
                new IdStamp(),
            ]),
        ];

        $storage->add(...$envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $envelopes[1]->withStamp(new PriorityStamp(1));
        $storage->update($envelopes[1]);

        $this->assertEquals($envelopes, $storage->all());
        $this->assertInstanceOf(
            \Flasher\Prime\Stamp\PriorityStamp::class,
            $envelopes[1]->get(\Flasher\Prime\Stamp\PriorityStamp::class)
        );
    }

    public function testRemoveEnvelopes(): void
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification(), [
                new IdStamp(),
            ]),
            new Envelope(new Notification(), [
                new IdStamp(),
            ]),
        ];

        $storage->add(...$envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->remove($envelopes[1]);
        $this->assertEquals([$envelopes[0]], $storage->all());
    }

    public function testRemoveMultipleEnvelopes(): void
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification(), [
                new IdStamp(),
            ]),
            new Envelope(new Notification(), [
                new IdStamp(),
            ]),
        ];

        $storage->add(...$envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->remove(...$envelopes);
        $this->assertEquals([], $storage->all());
    }

    public function testClearAllEnvelopes(): void
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification(), [
                new IdStamp(),
            ]),
            new Envelope(new Notification(), [
                new IdStamp(),
            ]),
        ];

        $storage->add(...$envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->clear();
        $this->assertEquals([], $storage->all());
    }

    private function getStorage(): Storage
    {
        $session = $this->app->make('session');

        return new Storage(new SessionBag($session));
    }
}
