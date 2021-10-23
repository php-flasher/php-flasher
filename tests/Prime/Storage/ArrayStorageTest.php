<?php

namespace Flasher\Tests\Prime\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\ArrayStorage;
use Flasher\Tests\Prime\TestCase;

final class ArrayStorageTest extends TestCase
{
    public function testAdd()
    {
        $storage = new ArrayStorage();
        $envelopes = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification());
            $storage->add($envelopes[$index]);
        }

        $this->assertCount(5, $storage->all());
    }

    public function testAddNotificationWithUuidStamp()
    {
        $storage = new ArrayStorage();
        $storage->add(new Envelope(new Notification()));

        $envelopes = $storage->all();

        $this->assertCount(1, $envelopes);

        $uuid = $envelopes[0]->get('Flasher\Prime\Stamp\UuidStamp');
        $this->assertNull($uuid);
    }

    public function testClear()
    {
        $storage = new ArrayStorage();
        $envelopes = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification());
            $storage->add($envelopes[$index]);
        }

        $storage->clear();

        $this->assertEquals(array(), $storage->all());
    }

    public function testRemove()
    {
        $storage = new ArrayStorage();
        $envelopes = array();

        foreach (range(0, 4) as $index) {
            $envelopes[$index] = new Envelope(new Notification(), new UuidStamp());
            $storage->add($envelopes[$index]);
        }

        $storage->remove($envelopes[0], $envelopes[2]);

        $actual = UuidStamp::indexByUuid($storage->all());
        $expected = UuidStamp::indexByUuid($envelopes[1], $envelopes[3], $envelopes[4]);

        $this->assertEquals(array(), array_diff_key($actual, $expected));
    }
}