<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\DelayStamp;

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

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        $stamp = $envelope->get('Flasher\Prime\Stamp\DelayStamp');

        if (!$stamp instanceof DelayStamp) {
            return false;
        }

        if (null !== $this->maxDelay && $stamp->getDelay() > $this->maxDelay) {
            return false;
        }

        return $stamp->getDelay() >= $this->minDelay;
    }
}
