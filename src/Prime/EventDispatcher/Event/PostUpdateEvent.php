<?php

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Envelope;

final class PostUpdateEvent
{
    /**
     * @var Envelope[]
     */
    private $envelopes;

    /**
     * @param Envelope[] $envelopes
     */
    public function __construct(array $envelopes)
    {
        $this->envelopes = $envelopes;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes()
    {
        return $this->envelopes;
    }
}
