<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Envelope;

final class PrioritySpecification implements SpecificationInterface
{
    /**
     * @var int
     */
    private $minPriority;

    /**
     * @var int|null
     */
    private $maxPriority;

    /**
     * @param int      $minPriority
     * @param int|null $maxPriority
     */
    public function __construct($minPriority, $maxPriority = null)
    {
        $this->minPriority = $minPriority;
        $this->maxPriority = $maxPriority;
    }

    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxPriority && $stamp->getPriority() > $this->maxPriority) {
            return false;
        }

        return $stamp->getPriority() >= $this->minPriority;
    }
}
