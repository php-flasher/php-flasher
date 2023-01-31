<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Storage\Bag\StaticBag;
use Flasher\Tests\Prime\TestCase;

class StaticBagTest extends TestCase
{
    /**
     * @return void
     */
    public function testStaticBag()
    {
        $bag = new StaticBag();

        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $bag->set($envelopes);

        $this->assertEquals($envelopes, $bag->get());
    }
}
