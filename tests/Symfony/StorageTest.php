<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Storage\Storage;
use Flasher\Symfony\Storage\SessionBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\SessionStorage\ArraySessionStorage;

final class StorageTest extends TestCase
{
    public function testInitialState(): void
    {
        $storage = $this->getStorage();
        $this->assertEquals([], $storage->all());
    }

    public function testAddEnvelope(): void
    {
        $uuid = new IdStamp();
        $envelope = new Envelope(new Notification());
        $envelope->withStamp($uuid);

        $storage = $this->getStorage();
        $storage->add($envelope);

        $this->assertEquals([$envelope], $storage->all());
    }

    public function testAddMultipleEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $storage = $this->getStorage();
        $storage->add($envelopes);

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

        $storage->add($envelopes);
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

        $storage->add($envelopes);
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

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->remove($envelopes);
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

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->clear();
        $this->assertEquals([], $storage->all());
    }

    private function getStorage(): Storage
    {
        $session = class_exists(\Symfony\Component\HttpFoundation\Session\Session::class)
            ? new Session(new MockArraySessionStorage())
            : new \Symfony\Component\HttpFoundation\Session(new ArraySessionStorage()); // @phpstan-ignore-line

        return new Storage(new SessionBag($session)); // @phpstan-ignore-line
    }
}
