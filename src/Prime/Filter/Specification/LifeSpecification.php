<?php

namespace Flasher\Prime\TestsFilter\Specification;

use Notify\Envelope;

final class LifeSpecification implements SpecificationInterface
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
     * @param \Notify\Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\TestsStamp\ReplayStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxLife && $stamp->getLife() > $this->maxLife) {
            return false;
        }

        return $stamp->getLife() >= $this->minLife;
    }
}
