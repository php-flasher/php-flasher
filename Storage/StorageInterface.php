<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\Envelope;

interface StorageInterface
{
    /**
     * @return Envelope|Envelope[]
     */
    public function all();

    /**
     * @param Envelope|Envelope[] $envelopes
     */
    public function add($envelopes);

    /**
     * @param Envelope|Envelope[] $envelopes
     */
    public function remove($envelopes);

    /**
     * Remove all notifications from the storage
     */
    public function clear();

    /**
     * @param Envelope|Envelope[] $envelopes
     */
    public function update($envelopes);
}
