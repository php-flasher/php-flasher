<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Envelope;

final class ReplaySpecification implements SpecificationInterface
{
    /**
     * @var int
     */
    private $minLife;

    /**
     * @var int|null
     */
    private $maxLife;

    public function __construct($minLife, $maxLife = null)
    {
        $this->minLife = $minLife;
        $this->maxLife = $maxLife;
    }

    /**
     * @param Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxLife && $stamp->getCount() > $this->maxLife) {
            return false;
        }

        return $stamp->getCount() >= $this->minLife;
    }
}
