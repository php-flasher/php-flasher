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
     * @var array|string
     */
    private $criteria;

    /**
     * @param Envelope[]   $envelopes
     * @param string|array $criteria
     */
    public function __construct(array $envelopes, $criteria = array())
    {
        $this->envelopes = $envelopes;
        $this->criteria  = $criteria;
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
     * @return array|string
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param array|string $criteria
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }
}
