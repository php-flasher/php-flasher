<?php

namespace Flasher\Symfony\Tests\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Tests\TestCase;
use Flasher\Symfony\Storage\Storage;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class StorageTest extends TestCase
{
    public function testInitialState()
    {
        $storage = new Storage(new Session(new MockArraySessionStorage()));
        $this->assertEquals(array(), $storage->all());
    }

    public function testAddEnvelope()
    {
        $storage = new Storage(new Session(new MockArraySessionStorage()));
        $envelope = new Envelope(new Notification());
        $storage->add($envelope);

        $this->assertEquals(array($envelope), $storage->all());
    }

    public function testAddMultipleEnvelopes()
    {
        $storage = new Storage(new Session(new MockArraySessionStorage()));
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $storage->add($envelopes);
        $this->assertEquals($envelopes, $storage->all());
    }

    public function testUpdateEnvelopes()
    {
        $storage = new Storage(new Session(new MockArraySessionStorage()));
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

    public function testRemoveEnvelopes()
    {
        $storage = new Storage(new Session(new MockArraySessionStorage()));
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

    public function testRemoveMultipleEnvelopes()
    {
        $storage = new Storage(new Session(new MockArraySessionStorage()));
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

    public function testClearAllEnvelopes()
    {
        $storage = new Storage(new Session(new MockArraySessionStorage()));
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
}
