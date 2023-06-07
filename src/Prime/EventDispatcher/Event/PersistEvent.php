<?php

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

final class PersistEvent
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

    /**
     * @param Envelope[] $envelopes
     *
     * @return void
     */
    public function setEnvelopes(array $envelopes)
    {
        $this->envelopes = $envelopes;
    }
}
