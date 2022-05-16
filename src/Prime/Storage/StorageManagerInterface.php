<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;

interface StorageManagerInterface
{
    /**
     * @return Envelope[]
     */
    public function all();

    /**
     * @param mixed[] $criteria
     *
     * @return Envelope[]
     */
    public function filter(array $criteria = array());

    /**
     * @param Envelope|Envelope[] $envelopes
     *
     * @return void
     */
    public function add($envelopes);

    /**
     * @param Envelope|Envelope[] $envelopes
     *
     * @return void
     */
    public function update($envelopes);

    /**
     * @param Envelope|Envelope[] $envelopes
     *
     * @return void
     */
    public function remove($envelopes);

    /**
     * remove All notifications from storage.
     *
     * @return void
     */
    public function clear();
}
