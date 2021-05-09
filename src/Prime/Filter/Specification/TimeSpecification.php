<?php

namespace Flasher\Prime\Filter\Specification;

use DateTime;
use Flasher\Prime\Envelope;

final class TimeSpecification implements SpecificationInterface
{
    /**
     * @var DateTime
     */
    private $minTime;

    /**
     * @var DateTime|null
     */
    private $maxTime;

    public function __construct(DateTime $minTime, DateTime $maxTime = null)
    {
        $this->minTime = $minTime;
        $this->maxTime = $maxTime;
    }

    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\CreatedAtStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxTime && $stamp->getCreatedAt() > $this->maxTime) {
            return false;
        }

        return $stamp->getCreatedAt() >= $this->minTime;
    }
}
