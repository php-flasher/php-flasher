<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Laravel;

use Flasher\Laravel\Storage\SessionBag;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageBag;

final class StorageTest extends TestCase
{
    public function testInitialState()
    {
        $storage = $this->getStorage();
        $this->assertEquals(array(), $storage->all());
    }

    public function testAddEnvelope()
    {
        $storage = $this->getStorage();
        $envelope = new Envelope(new Notification());
        $storage->add($envelope);

        $this->assertEquals(UuidStamp::indexByUuid($envelope), $storage->all());
    }

    public function testAddMultipleEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $storage->add($envelopes);
        $this->assertEquals(UuidStamp::indexByUuid($envelopes), $storage->all());
    }

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
        $this->assertEquals(UuidStamp::indexByUuid($envelopes[0]), $storage->all());
    }

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

    private function getStorage()
    {
        return new StorageBag(new SessionBag($this->app->make('session')));
    }
}
