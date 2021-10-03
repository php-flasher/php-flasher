<?php

namespace Flasher\Tests\Symfony\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Symfony\Storage\Storage;
use Flasher\Tests\Prime\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\SessionStorage\ArraySessionStorage;

class StorageTest extends TestCase
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

        $this->assertEquals(array($envelope), $storage->all());
    }

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

    private function getStorage()
    {
        $session = class_exists('Symfony\Component\HttpFoundation\Session\Session')
            ? new Session(new MockArraySessionStorage())
            : new Symfony\Component\HttpFoundation\Session(new ArraySessionStorage());

        return new Storage($session);
    }
}
