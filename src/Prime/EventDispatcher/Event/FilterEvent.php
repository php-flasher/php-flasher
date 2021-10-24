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
     * @var array<string, mixed>
     */
    private $criteria;

    /**
     * @param Envelope[] $envelopes
     * @param array<string, mixed> $criteria
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
     *
     * @return void
     */
    public function setEnvelopes(array $envelopes)
    {
        $this->envelopes = $envelopes;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param array<string, mixed> $criteria
     *
     * @return void
     */
    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;
    }
}
