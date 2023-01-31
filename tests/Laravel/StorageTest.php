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
        $storage = $this->getStorage();
        $envelope = new Envelope(new Notification());
        $storage->add($envelope);

        $this->assertEquals(array($envelope), $storage->all());
    }

    /**
     * @return void
     */
    public function testAddMultipleEnvelopes()
    {
        $storage = $this->getStorage();
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());
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
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());

        $storage->remove($envelopes[1]);
        $this->assertEquals(array($envelopes[0]), $storage->all());
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
        $this->assertEquals($envelopes, $storage->all());

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
        $this->assertEquals($envelopes, $storage->all());

        $storage->clear();
        $this->assertEquals(array(), $storage->all());
    }

    /**
     * @return StorageBag
     */
    private function getStorage()
    {
        /** @var \Illuminate\Session\Store $session */
        $session = $this->app->make('session');

        return new StorageBag(new SessionBag($session));
    }
}
