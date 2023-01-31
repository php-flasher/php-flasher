<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

interface BagInterface
{
    /**
     * @return Envelope[]
     */
    public function get();

    /**
     * @param Envelope[] $envelopes
     *
     * @return void
     */
    public function set(array $envelopes);
}
