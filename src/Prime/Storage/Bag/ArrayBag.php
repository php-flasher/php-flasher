<?php

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

final class ArrayBag implements BagInterface
{
    /**
     * @var Envelope[]
     */
    private $envelopes = [];

    public function get()
    {
        return $this->envelopes;
    }

    public function set(array $envelopes)
    {
        $this->envelopes = $envelopes;
    }
}
