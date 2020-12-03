<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\Envelope;

interface StorageManagerInterface
{
    /**
     * @param Envelope[] $envelopes
     */
    public function flush($envelopes);

    /**
     * @return Envelope[]
     */
    public function all();

    /**
     * @param Envelope $envelope
     */
    public function add(Envelope $envelope);

    /**
     * @param Envelope[] $envelopes
     */
    public function remove($envelopes);

    /**
     * remove All notifications from storage
     */
    public function clear();
}
