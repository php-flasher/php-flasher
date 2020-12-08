<?php

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Envelope;

final class BuildEvent
{
    /**
     * @var Envelope
     */
    private $envelope;

    /**
     * @param Envelope $envelope
     */
    public function __construct(Envelope $envelope)
    {
        $this->envelope = $envelope;
    }

    /**
     * @return Envelope
     */
    public function getEnvelope()
    {
        return $this->envelope;
    }

    /**
     * @param Envelope $envelope
     */
    public function setEnvelope(Envelope $envelope)
    {
        $this->envelope = $envelope;
    }
}
