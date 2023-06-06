<?php

namespace Flasher\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;

final class StaticBag implements BagInterface
{
    /**
     * @var Envelope[]
     */
    private static $envelopes = [];

    public function get()
    {
        return self::$envelopes;
    }

    public function set(array $envelopes)
    {
        self::$envelopes = $envelopes;
    }
}
