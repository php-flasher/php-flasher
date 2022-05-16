<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Storage;

use Flasher\Prime\Notification\Envelope;

interface StorageInterface
{
    /**
     * @return Envelope[]
     */
    public function all();

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
     * Remove all notifications from the storage.
     *
     * @return void
     */
    public function clear();
}
