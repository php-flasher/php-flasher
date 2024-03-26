<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Storage\Bag\ArrayBag;
use PHPUnit\Framework\TestCase;

final class ArrayBagTest extends TestCase
{
    private ArrayBag $bag;

    protected function setUp(): void
    {
        $this->bag = new ArrayBag();
    }

    /**
     * Test the `get` method of the `ArrayBag` class.
     * It should return an array of envelopes that have been set.
     */
    public function testGet(): void
    {
        $this->assertSame([], $this->bag->get());

        $envelope = new Envelope(new Notification());
        $this->bag->set([$envelope]);
        $this->assertSame([$envelope], $this->bag->get());
    }

    /**
     * Test the `set` method of the `ArrayBag` class.
     * It should set the envelopes in the bag.
     */
    public function testSet(): void
    {
        $envelope = new Envelope(new Notification());

        $this->bag->set([$envelope]);

        $envelopes = $this->bag->get();
        $this->assertSame([$envelope], $envelopes);
    }
}
