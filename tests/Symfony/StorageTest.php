<?php

namespace Flasher\Tests\Symfony;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageBag;
use Flasher\Symfony\Storage\SessionBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\SessionStorage\ArraySessionStorage;

class StorageTest extends TestCase
{
    /**
     * @return void
     */
    public function testInitialState()
    {
        $storage = $this->getStorage();
        $this->assertEquals([], $storage->all());
    }

    /**
     * @return void
     */
    public function testAddEnvelope()
    {
        $uuid = new UuidStamp();
        $envelope = new Envelope(new Notification());
        $envelope->withStamp($uuid);

        $storage = $this->getStorage();
        $storage->add($envelope);

        $this->assertEquals([$envelope], $storage->all());
    }

    /**
     * @return void
     */
    public function testAddMultipleEnvelopes()
    {
        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $storage = $this->getStorage();
        $storage->add($envelopes);

        $this->assertEquals($envelopes, $storage->all());
    }

    /**
     * @return void
     */
    public function testUpdateEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification(), [
                new UuidStamp(),
            ]),
            new Envelope(new Notification(), [
                new UuidStamp(),
            ]),
        ];

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $envelopes[1]->withStamp(new PriorityStamp(1));
        $storage->update($envelopes[1]);

        $this->assertEquals($envelopes, $storage->all());
        $this->assertInstanceOf(
            'Flasher\Prime\Stamp\PriorityStamp',
            $envelopes[1]->get('Flasher\Prime\Stamp\PriorityStamp')
        );
    }

    /**
     * @return void
     */
    public function testRemoveEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification(), [
                new UuidStamp(),
            ]),
            new Envelope(new Notification(), [
                new UuidStamp(),
            ]),
        ];

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->remove($envelopes[1]);
        $this->assertEquals([$envelopes[0]], $storage->all());
    }

    /**
     * @return void
     */
    public function testRemoveMultipleEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification(), [
                new UuidStamp(),
            ]),
            new Envelope(new Notification(), [
                new UuidStamp(),
            ]),
        ];

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->remove($envelopes);
        $this->assertEquals([], $storage->all());
    }

    /**
     * @return void
     */
    public function testClearAllEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = [
            new Envelope(new Notification(), [
                new UuidStamp(),
            ]),
            new Envelope(new Notification(), [
                new UuidStamp(),
            ]),
        ];

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->clear();
        $this->assertEquals([], $storage->all());
    }

    /**
     * @return StorageBag
     */
    private function getStorage()
    {
        $session = class_exists('Symfony\Component\HttpFoundation\Session\Session')
            ? new Session(new MockArraySessionStorage())
            : new \Symfony\Component\HttpFoundation\Session(new ArraySessionStorage()); // @phpstan-ignore-line

        return new StorageBag(new SessionBag($session)); // @phpstan-ignore-line
    }
}
