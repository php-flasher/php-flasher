<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

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

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

        if (!$stamp instanceof HopsStamp) {
            return false;
        }

        if (null !== $this->maxAmount && $stamp->getAmount() > $this->maxAmount) {
            return false;
        }

        return $stamp->getAmount() >= $this->minAmount;
    }
}
