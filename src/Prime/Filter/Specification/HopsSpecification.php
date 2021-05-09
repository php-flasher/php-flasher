<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Envelope;

final class HopsSpecification implements SpecificationInterface
{
    /**
     * @var int
     */
    private $minAmount;

    /**
     * @var int|null
     */
    private $maxAmount;

    /**
     * @param int      $minAmount
     * @param int|null $maxAmount
     */
    public function __construct($minAmount, $maxAmount = null)
    {
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
    }

    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

        if (null === $stamp) {
            return false;
        }

        if (null !== $this->maxAmount && $stamp->getAmount() > $this->maxAmount) {
            return false;
        }

        return $stamp->getAmount() >= $this->minAmount;
    }
}
