<?php

namespace Flasher\Tests\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Flasher\Tests\Prime\TestCase;

class ArrayBagTest extends TestCase
{
    /**
     * @return void
     */
    public function testArrayBag()
    {
        $bag = new ArrayBag();

        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $bag->set($envelopes);

        $this->assertEquals($envelopes, $bag->get());
    }
}
