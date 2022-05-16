<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

final class ArrayBag implements BagInterface
{
    /**
     * @var Envelope[]
     */
    private $envelopes = array();

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return $this->envelopes;
    }

    /**
     * {@inheritDoc}
     */
    public function set(array $envelopes)
    {
        $this->envelopes = $envelopes;
    }
}
