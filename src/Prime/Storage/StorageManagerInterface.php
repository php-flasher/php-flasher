<?php

namespace Flasher\Prime\TestsStorage;

use Notify\Envelope;

interface StorageManagerInterface
{
    /**
     * @param \Notify\Envelope[] $envelopes
     */
    public function flush($envelopes);

    /**
     * @return \Notify\Envelope[]
     */
    public function all();

    /**
     * @param \Notify\Envelope $envelope
     */
    public function add(Envelope $envelope);

    /**
     * @param \Notify\Envelope[] $envelopes
     */
    public function remove($envelopes);

    /**
     * remove All notifications from storage
     */
    public function clear();
}
