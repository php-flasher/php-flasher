<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Symfony;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageBag;
use Flasher\Symfony\Storage\SessionBag;
use Flasher\Tests\Prime\TestCase;
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
        $this->assertEquals(array(), $storage->all());
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

        $this->assertEquals(array($uuid->getUuid() => $envelope), $storage->all());
    }

    /**
     * @return void
     */
    public function testAddMultipleEnvelopes()
    {
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $storage = $this->getStorage();
        $storage->add($envelopes);

        $this->assertEquals(UuidStamp::indexByUuid($envelopes), $storage->all());
    }

    /**
     * @return void
     */
    public function testUpdateEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $storage->add($envelopes);
        $this->assertEquals(UuidStamp::indexByUuid($envelopes), $storage->all());

        $envelopes[1]->withStamp(new PriorityStamp(1));
        $storage->update($envelopes[1]);

        $this->assertEquals(UuidStamp::indexByUuid($envelopes), $storage->all());
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
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $storage->add($envelopes);
        $this->assertEquals(UuidStamp::indexByUuid($envelopes), $storage->all());

        $storage->remove($envelopes[1]);
        $this->assertEquals(UuidStamp::indexByUuid(array($envelopes[0])), $storage->all());
    }

    /**
     * @return void
     */
    public function testRemoveMultipleEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $storage->add($envelopes);
        $this->assertEquals(UuidStamp::indexByUuid($envelopes), $storage->all());

        $storage->remove($envelopes);
        $this->assertEquals(array(), $storage->all());
    }

    /**
     * @return void
     */
    public function testClearAllEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $storage->add($envelopes);
        $this->assertEquals(UuidStamp::indexByUuid($envelopes), $storage->all());

        $storage->clear();
        $this->assertEquals(array(), $storage->all());
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
