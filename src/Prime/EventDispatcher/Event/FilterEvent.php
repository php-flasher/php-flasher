<?php

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Envelope;

final class FilterEvent
{
    /**
     * @var Envelope[]
     */
    private $envelopes;

    /**
     * @var array
     */
    private $criteria;

    /**
     * @param Envelope[]   $envelopes
     */
    public function __construct(array $envelopes, array $criteria)
    {
        $this->envelopes = $envelopes;
        $this->criteria = $criteria;
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
     */
    public function setEnvelopes(array $envelopes)
    {
        $this->envelopes = $envelopes;
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;
    }
}
