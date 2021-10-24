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
     * remove All notifications from storage
     *
     * @return void
     */
    public function clear();
}
