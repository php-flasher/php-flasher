<?php

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

interface BagInterface
{
    /**
     * @return Envelope[]
     */
    public function get();

    /**
     * @param Envelope[] $envelopes
     *
     * @return void
     */
    public function set(array $envelopes);
}
