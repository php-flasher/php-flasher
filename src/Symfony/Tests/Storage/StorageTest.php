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
    /**
     * @var Storage
     */
    private $storage;

    protected function setUp()
    {
        $this->storage = new Storage(new Session(new MockArraySessionStorage()));
    }

    protected function tearDown()
    {
        $this->storage = null;
    }

    public function testInitialState()
    {
        $this->assertSame(array(), $this->storage->all());
    }

    public function testAddEnvelope()
    {
        $envelope = new Envelope(new Notification());
        $this->storage->add($envelope);

        $this->assertSame(array($envelope), $this->storage->all());
    }

    public function testAddMultipleEnvelopes()
    {
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $this->storage->add($envelopes);
        $this->assertSame($envelopes, $this->storage->all());
    }

    public function testUpdateEnvelopes()
    {
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $this->storage->add($envelopes);
        $this->assertSame($envelopes, $this->storage->all());

        $envelopes[1]->withStamp(new PriorityStamp(1));
        $this->storage->update($envelopes[1]);

        $this->assertSame($envelopes, $this->storage->all());
        $this->assertInstanceOf('Flasher\Prime\Stamp\PriorityStamp', $envelopes[1]->get('Flasher\Prime\Stamp\PriorityStamp'));
    }

    public function testRemoveEnvelopes()
    {
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $this->storage->add($envelopes);
        $this->assertSame($envelopes, $this->storage->all());

        $this->storage->remove($envelopes[1]);
        $this->assertSame(array($envelopes[0]), $this->storage->all());
    }

    public function testRemoveMultipleEnvelopes()
    {
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $this->storage->add($envelopes);
        $this->assertSame($envelopes, $this->storage->all());

        $this->storage->remove($envelopes);
        $this->assertSame(array(), $this->storage->all());
    }

    public function testClearAllEnvelopes()
    {
        $envelopes = array(
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
            new Envelope(new Notification(), array(
                new UuidStamp(),
            )),
        );

        $this->storage->add($envelopes);
        $this->assertSame($envelopes, $this->storage->all());

        $this->storage->clear();
        $this->assertSame(array(), $this->storage->all());
    }
}
