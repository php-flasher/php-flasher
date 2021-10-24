<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\Envelope;

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
    public function remove($envelopes);

    /**
     * Remove all notifications from the storage
     *
     * @return void
     */
    public function clear();

    /**
     * @param Envelope|Envelope[] $envelopes
     *
     * @return void
     */
    public function update($envelopes);
}
