<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PriorityStamp;

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

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');

        if (!$stamp instanceof PriorityStamp) {
            return false;
        }

        if (null !== $this->maxPriority && $stamp->getPriority() > $this->maxPriority) {
            return false;
        }

        return $stamp->getPriority() >= $this->minPriority;
    }
}
