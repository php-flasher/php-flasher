<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

final class StaticBag implements BagInterface
{
    /**
     * @var Envelope[]
     */
    private static $envelopes = array();

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return self::$envelopes;
    }

    /**
     * {@inheritDoc}
     */
    public function set(array $envelopes)
    {
        self::$envelopes = $envelopes;
    }
}
