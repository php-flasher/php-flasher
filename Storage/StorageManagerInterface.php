<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\Envelope;

interface StorageManagerInterface
{
    /**
     * @return Envelope[]
     */
    public function all();

    /**
     * @param Envelope|Envelope[] $envelopes
     */
    public function add($envelopes);

    /**
     * @param Envelope|Envelope[] $envelopes
     */
    public function update($envelopes);

    /**
     * @param Envelope|Envelope[] $envelopes
     */
    public function remove($envelopes);

    /**
     * remove All notifications from storage
     */
    public function clear();
}
