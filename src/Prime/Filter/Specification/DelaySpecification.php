<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Envelope;

final class DelaySpecification implements SpecificationInterface
{
    /**
     * @var int
     */
    private $minDelay;

    /**
     * @var int|null
     */
    private $maxDelay;

    /**
     * @param int      $minDelay
     * @param int|null $maxDelay
     */
    public function __construct($minDelay, $maxDelay = null)
    {
        $this->minDelay = $minDelay;
        $this->maxDelay = $maxDelay;
    }

    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxDelay && $stamp->getDelay() > $this->maxDelay) {
            return false;
        }

        return $stamp->getDelay() >= $this->minDelay;
    }
}
