<?php

namespace Flasher\Prime\TestsFilter\Specification;

use Notify\Envelope;

final class TimeSpecification implements SpecificationInterface
{
    /**
     * @var int
     */
    private $minTime;

    /**
     * @var int|null
     */
    private $maxTime;

    public function __construct($minTime, $maxTime = null)
    {
        $this->minTime = $minTime;
        $this->maxTime = $maxTime;
    }

    /**
     * @param \Notify\Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\TestsStamp\CreatedAtStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxTime && $stamp->getCreatedAt() > $this->maxTime) {
            return false;
        }

        return $stamp->getCreatedAt() >= $this->minTime;
    }
}
